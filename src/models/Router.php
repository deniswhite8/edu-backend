<?php

class Router
{
    private $_route;

    public function __construct($route)
    {
        list($this->_controller, $this->_action) = explode('_', $route);
        $this->_route = $route;
    }

    public function getController()
    {
        return ucfirst($this->_controller) . 'Controller';
    }

    public function getAction()
    {
        return $this->_action . 'Action';
    }
}