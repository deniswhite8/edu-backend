<?php

namespace App\Model;


class ProductOrder extends Entity
{
    public function setOrderId($orderId)
    {
        $this->setField('order_id', $orderId);
    }

    public function setQty($qty)
    {
        $this->setField('qty', $qty);
    }

    public function setProduct(Product $product)
    {
        $this->setField('name', $product->getName());
        $this->setField('sku', $product->getSku());
        $this->setField('price', $product->getPrice());
        $this->setField('special_price', $product->getSpecialPrice());
    }
} 