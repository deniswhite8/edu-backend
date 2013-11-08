<?php

class Router
{
    public function __construct($route)
    {
        if ($route) {
            list($this->_controller, $this->_action) = explode('_', $route);
        } else {
            $this->_controller = "Product";
            $this->_action = "view";
        }

    }

    public function getController()
    {
        return ucfirst($this->_controller) . 'Controller';
    }

    public function getAction()
    {
        return lcfirst($this->_action) . 'Action';
    }
}