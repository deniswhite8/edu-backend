<?php

require_once __DIR__ . '/Entity.php';

class Product extends Entity
{
    public function getSku()
    {
        return $this->getField('sku');
    }

    public function getName()
    {
        return $this->getField('name');
    }

    public function getImage()
    {
        return $this->getField('image');
    }

    public function getPrice()
    {
        return $this->getField('price');
    }

    public function getSpecialPrice()
    {
        return $this->getField('special_price');
    }

    public function isSpecialPriceApplied()
    {
        return (bool) $this->getSpecialPrice();
    }

    public function getId()
    {
        return $this->getField('product_id');
    }
}
