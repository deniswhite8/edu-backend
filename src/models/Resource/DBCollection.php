<?php
class DBCollection implements IResourceCollection
{
    private $_connection;
    private $_table;

    public function __construct(PDO $connection, $table)
    {
        $this->_connection = $connection;
        $this->_table = $table;
    }

    public function fetch()
    {
        return $this->_connection->query("SELECT * FROM {$this->_table}")
            ->fetchAll(PDO::FETCH_ASSOC);
    }

    public function whereEqual($field, $val)
    {
        return $this->_connection->query("SELECT * FROM {$this->_table} WHERE {$field}={$val}")
            ->fetchAll(PDO::FETCH_ASSOC);
    }

    public function avg($avgfield)
    {
        return $this->_connection->query("SELECT AVG({$avgfield}) FROM {$this->_table}")
            ->fetchAll(PDO::FETCH_ASSOC);
    }

    public function avgWithWhereEqual($avgfield, $field, $val)
    {
        return $this->_connection->query("SELECT AVG({$avgfield}) FROM {$this->_table} WHERE {$field}={$val}")
                    ->fetchAll(PDO::FETCH_ASSOC);
    }
}