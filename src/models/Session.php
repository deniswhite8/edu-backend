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

        $customer = new Customer([], $this->_resource);
        $customer->load($_SESSION['id']);
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

    public function generateToken()
    {
        $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(32));
    }

    public function getToken()
    {
        return isset($_SESSION['token']) ? $_SESSION['token'] : null;
    }

    public function validateToken($token)
    {
        $valid = $this->getToken() === $token;
        unset($_SESSION['token']);
        return $valid;
    }

    public function getQuoteId()
    {
        if ($this->isLoggedIn())
            return $this->getCustomer()->getQuoteId();
        else
            return isset($_SESSION['quote_id']) ? $_SESSION['quote_id'] : null;
    }

    public function setQuoteId($id)
    {
        if ($this->isLoggedIn())
            $this->getCustomer()->setQuoteId($id);
        else
            $_SESSION['quote_id'] = $id;
    }
}