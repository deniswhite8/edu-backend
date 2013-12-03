<?php
require_once __DIR__ . '/IResourceEntity.php';
class DBEntity implements IResourceEntity
{
    private $_connection;
    private $_table;
    private $_primaryKey;

    public function __construct(PDO $connection, $table, $primaryKey)
    {
        $this->_connection = $connection;
        $this->_table = $table;
        $this->_primaryKey = $primaryKey;
    }

    public function find($id)
    {
        $smtm = $this->_connection->prepare("SELECT * FROM {$this->_table} WHERE {$this->_primaryKey} = :id");
        $smtm->execute([':id' => $id]);
        return $smtm->fetch(PDO::FETCH_ASSOC);
    }
}