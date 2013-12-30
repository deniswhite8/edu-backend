<?php

namespace App\Model\Quote;


use App\Model\Order;
use App\Model\Quote;
use App\Model\ProductOrder;
use App\Model\QuoteItemCollection;
use App\Model\Region;
use App\Model\City;
use App\Model\Session;
use App\Model\Product;

class AddressConverter implements IConverter
{
    public function toOrder(Quote $quote, Order $order, ProductOrder $productOrderPrototype, Session $session,
                            QuoteItemCollection $quoteItemPrototype, Product $productPrototype, City $cityPrototype, Region $regionPrototype)
    {
        $address = $quote->getAddress();
        $cityPrototype->load($address->getCityId());
        $regionPrototype->load($address->getRegionId());

        $order->setField('city_name', $cityPrototype->getName());
        $order->setField('region_name', $regionPrototype->getName());
        $order->setField('zip_code', $address->getZipCode());
        $order->setField('street', $address->getStreet());
        $order->setField('house', $address->getHouse());
        $order->setField('flat', $address->getFlat());
    }
}