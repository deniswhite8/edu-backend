<?php

namespace App\Model\Quote;

use App\Model\Quote;
use App\Model\Product;

class SubtotalCollector implements ICollector
{
    private $_product;

    public function __construct($product)
    {
        $this->_product = $product;
    }

    public function collect(Quote $quote)
    {
        $sum = 0;

        $items = $quote->getQuoteItemsCollection();
        $items->filterByQuote($quote);
        foreach ($items->getItems() as $item) {
            $this->_product->load($item->getProductId());
            $count = $item->getQty();

            if ($this->_product->isSpecialPriceApplied())
                $sum += $this->_product->getSpecialPrice() * $count;
            else
                $sum += $this->_product->getPrice() * $count;
        }

        return $sum;
    }
}