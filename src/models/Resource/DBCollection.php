<?php
namespace App\Model\Resource;


use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;
use Zend\Db\Sql\Predicate\Like;

class DBCollection
    implements IResourceCollection
{
    private $_connection;
    private $_table;
    private $_filters = [];
    private $_bind = [];
    private $_select, $_driver, $_adapter, $_sql;
    private $_limit, $_offset;
    private $_order, $_reverse;
    private $_isLike = [];

    public function __construct(\PDO $connection, Table\ITable $table)
    {
        $this->_connection = $connection;
        $this->_table = $table;

        $this->_driver = new \Zend\Db\Adapter\Driver\Pdo\Pdo($this->_connection);
        $this->_adapter = new \Zend\Db\Adapter\Adapter($this->_driver);
        $this->_sql = new \Zend\Db\Sql\Sql($this->_adapter);


        $this->_select = $this->_sql->select($this->_table->getName());

    }

    private function _executeSelect($columns = null)
    {
        $this->_select = $this->_sql->select($this->_table->getName());

        if ($columns) {
            $this->_select->columns($columns);
        }


        $this->_prepareFilters();
        $this->_prepareLimit();
        $this->_prepareOrder();


        $statement = $this->_sql->prepareStatementForSqlObject($this->_select);
        $result = $statement->execute($this->_bind);

        return $result;
    }


    public function fetch()
    {
        $result = $this->_executeSelect();

        $resultSet = new ResultSet();
        $resultSet->initialize($result);
        return $resultSet->toArray();
    }

    public function average($column)
    {
        $results = $this->_executeSelect(
            ['avg' => new \Zend\Db\Sql\Expression("AVG({$column})")]
        );

        return $results->current()['avg'];
    }

    public function filterBy($column, $value)
    {
        $this->_filters[$column] = $value;
    }

    public function likeBy($column, $value)
    {
        $this->_filters[$column] = $value;
        $this->_isLike[$column] = true;
    }

    public function limit($limit, $offset = 0)
    {
        $this->_limit = $limit;
        $this->_offset = $offset;
    }

    public function sortBy($column, $reverse = false)
    {
        $this->_order = $column;
        $this->_reverse = $reverse;
    }

    public function count()
    {
        $this->_prepareFilters();
        $this->_prepareLimit();

        $select = clone $this->_select;


        $select->reset(Select::LIMIT)
               ->reset(Select::OFFSET);

        $select->columns(['count' => new \Zend\Db\Sql\Expression("COUNT(*)")]);

        $statement = $this->_sql->prepareStatementForSqlObject($select);
        $results = $statement->execute($this->_bind);
        return $results->current()['count'];

    }

    private function _prepareFilters()
    {
        foreach ($this->_filters as $column => $value) {
            if(isset($this->_isLike[$column])) {
                $this->_select->where("{$column} LIKE :{$column}");
            }
            else
                $this->_select->where("{$column} = :{$column}");
            $this->_bind[$column] = $value;
        }
    }

    private function _prepareLimit()
    {
        if ($this->_limit)
            $this->_select->limit($this->_limit);
        if ($this->_offset)
            $this->_select->offset($this->_offset);
    }

    private function _prepareOrder()
    {
        if ($this->_order) {
            $this->_select->order($this->_order . ($this->_reverse ? ' DESC' : ''));
        }
    }
}
