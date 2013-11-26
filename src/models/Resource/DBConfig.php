<?php

class DBConfig
{
    private $_connection;
    private $_primaryKeys;

    public function setDB($host, $dbName, $userName, $password)
    {
        $this->_connection = new PDO("mysql:host={$host};dbname={$dbName}", $userName, $password);
    }

    public function setPrimaryKeys(array $data)
    {
        $this->_primaryKeys = $data;
    }


    public function getConnection()
    {
        return $this->_connection;
    }

    public function getPrimaryKey($tableName)
    {
        return $this->_primaryKeys[$tableName];
    }
}