<?php

namespace Test\Model\Shipping;

class FactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testReturnsShippingMethodsInstance()
    {
        $factory = new \App\Model\Shipping\Factory;
        $classes = array_map(function($method) {
            return get_class($method);
        }, $factory->getMethods());
        $this->assertEquals(['App\Model\Shipping\Fixed', 'App\Model\Shipping\TableRate'], $classes);
    }
}