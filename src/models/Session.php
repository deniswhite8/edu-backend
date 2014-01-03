<?php

namespace App\Model;

use App\Model\Resource\DBEntity;
use App\Model\Resource\Table\Customer as CustomerTable;
use App\Model\Resource\Table\Admin as AdminTable;

class Session
{

    private $_resource, $_customerResource, $_adminResource;
    private $_mode, $_userIdName;

    public function __construct()
    {
        if (!isset($_SESSION)) session_start();
        $connection = new \PDO('mysql:host=localhost;dbname=student', 'root', '123');
        $this->_customerResource = new DBEntity($connection, new CustomerTable);
        $this->_adminResource = new DBEntity($connection, new AdminTable);

        $this->setCustomerMode();
    }


    public function setCustomerMode()
    {
        $this->_mode = 'customer';
        $this->_userIdName = 'id';
        $this->_resource = $this->_customerResource;
    }

    public function setAdminMode()
    {
        $this->_mode = 'admin';
        $this->_userIdName = 'admin_id';
        $this->_resource = $this->_adminResource;
    }

    public function isLoggedIn()
    {
        return isset($_SESSION[$this->_userIdName]);
    }

    public function getCustomer()
    {
        if (!$this->isLoggedIn()) return null;

        $customer = new Customer([], $this->_resource);
        $customer->load($_SESSION[$this->_userIdName]);
        return $customer;
    }

    public function getAdmin()
    {
        if (!$this->isLoggedIn()) return null;

        $admin = new Admin([], $this->_resource);
        $admin->load($_SESSION[$this->_userIdName]);
        return $admin;
    }

    public function getSessionId()
    {
        return session_id();
    }

    public function login($id)
    {
        if ($id) {
            $_SESSION[$this->_userIdName] = $id;
        }
    }

    public function logout()
    {
        unset($_SESSION[$this->_userIdName]);
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
