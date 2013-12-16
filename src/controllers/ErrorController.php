<?php
namespace App\Controller;

use App\Model\Controller;

class ErrorController extends ActionController
{
    public function notFoundAction()
    {
        return $this->_di->get('View', [
            'template' => 'pageNotFound'
        ]);
    }
}
