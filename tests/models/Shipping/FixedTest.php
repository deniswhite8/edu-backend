<?php
/**
 * Created by PhpStorm.
 * User: denis
 * Date: 19.12.13
 * Time: 20:14
 */

namespace Test\Model\Shipping;


class FixedTest extends \PHPUnit_Framework_TestCase
{
    public function testReturnsPrice()
    {
        $fixed = new \App\Model\Shipping\Fixed;
        $this->assertEquals(42, $this->getPrice());
    }
} 