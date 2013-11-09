<?php

require_once __DIR__ . '/../src/models/Router.php';

class RouterTest extends PHPUnit_Framework_TestCase
{
    public function testReturnsControllerName()
    {
        $router = new Router('product_view');
        $this->assertEquals('ProductController', $router->getController());

        $router = new Router('Product_view');
        $this->assertEquals('ProductController', $router->getController());
    }

    public function testReturnActionName()
    {
        $router = new Router('product_view');
        $this->assertEquals('viewAction', $router->getAction());

        $router = new Router('product_View');
        $this->assertEquals('viewAction', $router->getAction());
    }

    public function testReturnPageNotFoundError()
    {
        $router = new Router('foo_bar');
        $this->assertEquals('ErrorController', $router->getController());
        $this->assertEquals('pageNotFoundAction', $router->getAction());

        $router = new Router('foo_view');
        $this->assertEquals('ErrorController', $router->getController());
        $this->assertEquals('pageNotFoundAction', $router->getAction());

        $router = new Router('product_bar');
        $this->assertEquals('ErrorController', $router->getController());
        $this->assertEquals('pageNotFoundAction', $router->getAction());
    }
}