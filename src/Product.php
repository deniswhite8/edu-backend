<?php

require_once __DIR__ . '/Сontainer.php';

class Product extends Сontainer
{
    public function getSku()
    {
        return $this->_getData('sku');
    }

    public function getName()
    {
        return $this->_getData('name');
    }

    public function getImage()
    {
        return $this->_getData('image');
    }

    public function getPrice()
    {
        return $this->_getData('price');
    }

    public function getSpecialPrice()
    {
        return $this->_getData('special_price');
    }

    public function isSpecialPriceApplied()
    {
        return (bool) $this->getSpecialPrice();
    }
}