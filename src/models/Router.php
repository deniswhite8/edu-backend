<?php

class PageNotFoundException extends Exception
{
}

class Router
{
    private $_controllerName;
    private $_actionName;

    public function __construct($route)
    {
        if ($route) {
            list($this->_controller, $this->_action) = explode('_', $route);
        } else {
            $this->_controller = "Product";
            $this->_action = "list";
        }

        $this->_controllerName = ucfirst($this->_controller) . 'Controller';
        $this->_actionName = lcfirst($this->_action) . 'Action';

        if ($this->_isExist()) {
            throw new PageNotFoundException('Page not found');
        }
    }

    private function _isExist()
    {
        $notFoundError = false;

        if (file_exists(__DIR__ . "/../controllers/{$this->_controllerName}.php")) {
            require_once __DIR__ . "/../controllers/{$this->_controllerName}.php";
            if (!class_exists($this->_controllerName) || !in_array($this->_actionName, get_class_methods($this->_controllerName))) {
                $notFoundError = true;
            }
        } else {
            $notFoundError = true;
        }

        return $notFoundError;
    }

    public function getController()
    {
        return $this->_controllerName;
    }

    public function getAction()
    {
        return $this->_actionName;
    }
}