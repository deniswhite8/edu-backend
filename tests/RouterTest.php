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
        $exp = null;

        try {
            $router = new Router('foo_bar');
        } catch (PageNotFoundException $ex) {
            $exp = $ex;
        }
        $this->assertEquals(new PageNotFoundException(), $exp);

        $exp = null;
        try {
            $router = new Router('foo_view');
        } catch (PageNotFoundException $ex) {
            $exp = $ex;
        }
        $this->assertEquals(new PageNotFoundException(), $exp);

        $exp = null;
        try {
            $router = new Router('product_bar');
        } catch (PageNotFoundException $ex) {
            $exp = $ex;
        }
        $this->assertEquals(new PageNotFoundException(), $exp);
    }
}