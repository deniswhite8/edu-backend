<?php

namespace App\Model\Quote;


class CollectorsFactory
{
    private $_product;

    public function __construct($productPrototype = null)
    {
        $this->_product = $productPrototype;
    }

    public function getCollectors()
    {
        return [
            'subtotal'    => new SubtotalCollector($this->_product),
            'shipping'    => new ShippingCollector(),
            'grand_total' => new GrandTotalCollector()
        ];
    }
}
 