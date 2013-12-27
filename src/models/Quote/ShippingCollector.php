<?php

namespace App\Model\Quote;

use App\Model\Quote;
use App\Model\Shipping\Factory;

class ShippingCollector implements ICollector
{


    public function collect(Quote $quote)
    {
        $shippingMethod = $quote->getShippingMethod();
        $method = (new Factory($quote->getAddress()))->getMethodByCode($shippingMethod);
        return $method->getPrice();
    }
}