<?php
namespace App\Controller;

use App\Model\Controller;

class ErrorController extends Controller
{
    public function notFoundAction()
    {
        return $this->_di->get('View', [
            'template' => 'pageNotFound'
        ]);
    }
}
