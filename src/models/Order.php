<?php

namespace App\Model;

class Order extends Entity
{
    public function setCustomerId($customerId)
    {
        $this->setField('customer_id', $customerId);
    }

    public function setShippingMethod($shippingMethod)
    {
        $this->setField('shipping_method_code', $shippingMethod);
    }

    public function setPaymentMethod($paymentMethod)
    {
        $this->setField('payment_method_code', $paymentMethod);
    }


    public function setTotals($shipping, $subtotal, $total)
    {
        $this->setField('shipping', $shipping);
        $this->setField('subtotal', $subtotal);
        $this->setField('grand_total', $total);
    }
}
 