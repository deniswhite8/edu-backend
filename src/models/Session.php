<?php

namespace App\Model;

use App\Model\Resource\DBEntity;
use App\Model\Resource\Table\Customer as CustomerTable;

class Session
{

    private $_resource;

    public function __construct()
    {
        if (!isset($_SESSION)) session_start();
        $connection = new \PDO('mysql:host=localhost;dbname=student', 'root', '123');
        $this->_resource = new DBEntity($connection, new CustomerTable);
    }

    public function isLoggedIn()
    {
        return isset($_SESSION['id']);
    }

    public function getCustomer()
    {
        if (!$this->isLoggedIn()) return null;

        $customer = new Customer([]);
        $customer->load($this->_resource, $_SESSION['id']);
        return $customer;
    }

    public function getSessionId()
    {
        return session_id();
    }

    public function login($id)
    {
        if ($id)
            $_SESSION['id'] = $id;
    }

    public function logout()
    {
        unset($_SESSION['id']);
    }
}