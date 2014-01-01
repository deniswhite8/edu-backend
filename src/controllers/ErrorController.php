<?php
namespace App\Controller;

class ErrorController extends ActionController
{
    public function notFoundAction()
    {
        return $this->_di->get('View', [
            'template' => 'pageNotFound'
        ]);
    }
}
