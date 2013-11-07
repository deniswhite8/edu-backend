<?php

require_once __DIR__ . '/../src/models/Router.php';

class RouterTest extends PHPUnit_Framework_TestCase
{
    public function testReturnsControllerName()
    {
        $router = new Router('foo_bar');
        $this->assertEquals('FooController', $router->getController());

        $router = new Router('product_bar');
        $this->assertEquals('ProductController', $router->getController());
    }

    public function testReturnActionName()
    {
        $router = new Router('foo_bar');
        $this->assertEquals('barAction', $router->getAction());

        $router = new Router('product_bar');
        $this->assertEquals('barAction', $router->getAction());
    }
}