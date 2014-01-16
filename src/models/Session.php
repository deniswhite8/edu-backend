<?php

namespace App\Model;

use App\Model\Resource\DBEntity;
use App\Model\Resource\Table\Customer as CustomerTable;
use App\Model\Resource\Table\Admin as AdminTable;

class Session
{
    private $_userIdName;
    private $_customer, $_admin;
    private $_quoteCollection;

    public function __construct($customer, $admin, $quoteCollection)
    {
        if (!isset($_SESSION)) session_start();

        $this->_customer = $customer;
        $this->_admin = $admin;
        $this->_quoteCollection = $quoteCollection;

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

        $this->_customer->load($_SESSION['id']);
        return $this->_customer;
    }

    public function getAdmin()
    {
        if (!$this->isLoggedIn()) return null;

        $this->_admin->load($_SESSION['admin_id']);
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
        $this->_quoteCollection->clear();

        if ($this->isLoggedIn())
            $this->_quoteCollection->filterByCustomerId($_SESSION['id']);
        else
            $this->_quoteCollection->filterBySessionId($this->getSessionId());

        $this->_quoteCollection->setLast();
        $quotes = $this->_quoteCollection->getQuotes();

        if (empty($quotes)) return null;
        else return reset($quotes)->getId();
    }

    public function setQuoteId($quote)
    {
        if ($this->isLoggedIn())
            $quote->setCustomerId($_SESSION['id']);
        else
            $quote->setSessionId($this->getSessionId());

        $quote->save();
    }
}
