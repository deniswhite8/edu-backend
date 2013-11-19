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


    /**
     * @expectedException PageNotFoundException
     * @expectedExceptionMessage Page not found
     */
    public function testRouterException1()
    {

        new Router('foo_bar');
    }

    /**
     * @expectedException PageNotFoundException
     * @expectedExceptionMessage Page not found
     */
    public function testRouterException2()
    {
        new Router('foo_view');
    }

    /**
     * @expectedException PageNotFoundException
     * @expectedExceptionMessage Page not found
     */
    public function testRouterException3()
    {
        new Router('product_bar');
    }
}