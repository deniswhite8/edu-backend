<?php

namespace App\Controller;

class CustomerController
{
    public function loginAction()
    {
        $_page = 'customer_login';
        require_once __DIR__ . '/../views/layout/main.phtml';
    }

    public function registerAction()
    {
        $_page = 'customer_register';
        require_once __DIR__ . '/../views/layout/main.phtml';
    }
}