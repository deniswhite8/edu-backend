<?php
namespace App\Controller;

class ErrorController
{
    public function notFoundAction()
    {
        $view = 'pageNotFound';
        require_once __DIR__ . '/../views/layout/base.phtml';
    }
}
