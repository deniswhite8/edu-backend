<?php

namespace Test\Model;

use App\Model\Order;

class OrderTest extends \PHPUnit_Framework_TestCase {

    public function testSetCustomerId()
    {
        $order = new Order(null, null);
        $order->setCustomerId(17);
        $this->assertEquals(17, $order->getData('customer_id'));
    }

    public function testSetShippingMethod()
    {
        $order = new Order(null, null);
        $order->setShippingMethod('lol');
        $this->assertEquals('lol', $order->getData('shipping_method_code'));
    }

    public function testSetPaymentCode()
    {
        $order = new Order(null, null);
        $order->setPaymentMethod('lol');
        $this->assertEquals('lol', $order->getData('payment_method_code'));
    }

    public function testSetTotals()
    {
        $order = new Order(null, null);
        $order->setTotals(100,200,300);

        $this->assertEquals(100, $order->getData('shipping'));
        $this->assertEquals(200, $order->getData('subtotal'));
        $this->assertEquals(300, $order->getData('grand_total'));
    }
}