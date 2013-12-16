<?php

namespace App\Model;

class Controller
{
    protected  $_di;

    public function __construct(\Zend\Di\Di $di)
    {
        $this->_di = $di;
    }
}