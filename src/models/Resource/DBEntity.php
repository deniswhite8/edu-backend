<?php
namespace App\Model\Resource;

class DBEntity
    implements IResourceEntity
{
    private $_connection;
    private $_table;

    public function __construct(\PDO $connection, Table\ITable $table)
    {
        $this->_connection = $connection;
        $this->_table = $table;
    }

    public function find($id)
    {
        $stmt = $this->_connection->prepare(
            "SELECT * FROM {$this->_table->getName()} WHERE {$this->_table->getPrimaryKey()} = :id"
        );
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function save($data)
    {
        if (isset($data[$this->_table->getPrimaryKey()])) {
            $id = $this->find($data[$this->_table->getPrimaryKey()]);
        }

        if ($id) {
            $updateList = array_map(function ($field) {
                return "{$field} = :{$field}";
            }, array_keys($data));

            $bind = array_map(function ($field) {
                return ":{$field}";
            }, array_keys($data));

            $updateList = implode(',', $updateList);
            $condition = "{$this->_table->getPrimaryKey()} = :{$this->_table->getPrimaryKey()}";
            $smtm = $this->_connection->prepare(
                "UPDATE {$this->_table->getName()} SET ({$updateList}) WHERE {$condition}"
            );
        } else {
            $columns = [];
            $bind = [];
            foreach ($data as $column => $value) {
                $bind[] = ':_param_' . $column;
                $columns[] = $column;

            }

            $fieldList = implode(',', $columns);
            $bindList = implode(',', $bind);


            $smtm = $this->_connection->prepare(
                "INSERT INTO {$this->_table->getName()} ({$fieldList}) VALUES ({$bindList})"
            );
            $smtm->execute(array_combine($bind, $data));
        }
    }
}