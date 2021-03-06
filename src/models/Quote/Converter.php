<?php

namespace App\Model\Quote;

use App\Model\Order;
use App\Model\Quote;
use App\Model\ProductOrder;
use App\Model\QuoteItemCollection;
use App\Model\Session;
use App\Model\Product;
use App\Model\Region;
use App\Model\City;

class Converter
{
    private $_converterFactory;

    public function __construct(\App\Model\Quote\ConverterFactory $converterFactory)
    {
        $this->_converterFactory = $converterFactory;
    }

    public function toOrder(Quote $quote, Order $order, ProductOrder $productOrderPrototype, Session $session,
                            QuoteItemCollection $quoteItemPrototype, Product $productPrototype, City $cityPrototype, Region $regionPrototype)
    {
        foreach ($this->_converterFactory->getConverters() as $converter) {
            $converter->toOrder($quote, $order, $productOrderPrototype, $session, $quoteItemPrototype, $productPrototype, $cityPrototype, $regionPrototype);
        }
    }
}
 