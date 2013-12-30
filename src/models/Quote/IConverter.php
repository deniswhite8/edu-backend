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

interface IConverter
{
    public function toOrder(Quote $quote, Order $order, ProductOrder $productOrderPrototype, Session $session,
                            QuoteItemCollection $quoteItemPrototype, Product $productPrototype, City $cityPrototype, Region $regionPrototype);
}
 