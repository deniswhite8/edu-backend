<?php
namespace App\Model\Resource;


use Zend\Db\ResultSet\ResultSet;

class DBCollection
    implements IResourceCollection
{
    private $_connection;
    private $_table;
    private $_filters = [];
    private $_select, $_driver, $_adapter, $_sql;
    private $_limit, $_offset;

    public function __construct(\PDO $connection, Table\ITable $table)
    {
        $this->_connection = $connection;
        $this->_table = $table;

        $this->_driver = new \Zend\Db\Adapter\Driver\Pdo\Pdo($this->_connection);
        $this->_adapter = new \Zend\Db\Adapter\Adapter($this->_driver);
        $this->_sql = new \Zend\Db\Sql\Sql($this->_adapter);
    }

    private function _executeSelect($columns = null)
    {
        $this->_select = $this->_sql->select($this->_table->getName());

        if ($columns) {
            $this->_select->columns($columns);
        }

        $this->_prepareFilters();

        $statement = $this->_sql->prepareStatementForSqlObject($this->_select);
        $result = $statement->execute();

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

    public function limit($limit)
    {
        $this->_limit = $limit;
    }

    public function offset($offset)
    {
        $this->_offset = $offset;
    }

    private function _prepareFilters()
    {
        foreach ($this->_filters as $column => $value) {
//            $this->_select->where("{$column} = :{$column}");
            $this->_select->where("{$column} = '{$value}'");
        }
    }

    private function _prepareLimit()
    {
        $this->_select->limit($this->_limit);
        $this->_select->offset($this->_offset);
    }
}
