<?php

namespace App\Model;

use App\Model\Resource\DBEntity;
use App\Model\Resource\Table\Customer as CustomerTable;
use App\Model\Resource\Table\Admin as AdminTable;

class Session
{
    private $_userIdName;
    private $_customer, $_admin;

    public function __construct($customer, $admin)
    {
        if (!isset($_SESSION)) session_start();

        $this->_customer = $customer;
        $this->_admin = $admin;

        $this->setCustomerMode();
    }


    public function setCustomerMode()
    {
        $this->_userIdName = 'id';
    }

    public function setAdminMode()
    {
        $this->_userIdName = 'admin_id';
    }

    public function isLoggedIn()
    {
        return isset($_SESSION[$this->_userIdName]);
    }

    public function getCustomer()
    {
        if (!$this->isLoggedIn()) return null;

        $this->_customer->load($_SESSION[$this->_userIdName]);
        return $this->_customer;
    }

    public function getAdmin()
    {
        if (!$this->isLoggedIn()) return null;

        $this->_admin->load($_SESSION[$this->_userIdName]);
        return $this->_admin;
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
