<?php
namespace App\Controller;

class ErrorController
{
    public function notFoundAction()
    {
        $_page = 'pageNotFound';
        require_once __DIR__ . '/../views/layout/main.phtml';
    }
}
