<?php

require_once __DIR__ . '/../../src/models/Resource/DBConfig.php';

class DBConfigTest extends PHPUnit_Framework_TestCase
{
    public function testPrimaryKey()
    {
        $conf = new DBConfig();
        $conf->setPrimaryKeys(['a' => 'b', 'c' => 'd', 'e' => 'f']);
        $this->assertEquals('d', $conf->getPrimaryKey('c'));
    }
} 