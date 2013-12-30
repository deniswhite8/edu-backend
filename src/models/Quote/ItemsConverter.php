<?php

namespace App\Model\Quote;

use App\Model\Order;
use App\Model\Product;
use App\Model\Quote;
use App\Model\QuoteItemCollection;
use App\Model\ProductOrder;
use App\Model\Session;
use App\Model\Region;
use App\Model\City;

class ItemsConverter implements IConverter
{
    public function toOrder(Quote $quote, Order $order, ProductOrder $productOrderPrototype, Session $session,
                            QuoteItemCollection $quoteItemPrototype, Product $productPrototype, City $cityPrototype, Region $regionPrototype)
    {
        foreach ($quote->getItems() as $quoteItem) {
            $productOrderPrototype->setData([], true);

            $productOrderPrototype->setField('order_id', $order->getId());
            $productOrderPrototype->setField('qty', $quoteItem->getQty());

            $productPrototype->load($quoteItem->getProductId());
            $productOrderPrototype->setField('name', $productPrototype->getName());
            $productOrderPrototype->setField('sku', $productPrototype->getSku());
            $productOrderPrototype->setField('price', $productPrototype->getPrice());
            $productOrderPrototype->setField('special_price', $productPrototype->getSpecialPrice());
            $productOrderPrototype->setField('order_id', $order->getId());

            $productOrderPrototype->save();
        }
    }
}