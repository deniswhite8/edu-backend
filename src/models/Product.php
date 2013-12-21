<?php
namespace App\Model;

class Product extends Entity
{
    public function getSku()
    {
        return $this->getData('sku');
    }

    public function getName()
    {
        return $this->getData('name');
    }

    public function getImage()
    {
        return $this->getData('image');
    }

    public function getPrice()
    {
        return $this->getData('price');
    }

    public function getSpecialPrice()
    {
        return $this->getData('special_price');
    }

    public function isSpecialPriceApplied()
    {
        return $this->getSpecialPrice() > 0;
    }
}
