<?php

class ProductCollection
{
    private $_productArray = array();
    private $_offsetCount, $_limitCount;

    public function __construct($productArray)
    {
        $this->_productArray = $productArray;
        $this->_offsetCount = 0;
        $this->_limitCount = count($this->_productArray);
    }

    public function getProducts()
    {
        return array_slice($this->_productArray, $this->_offsetCount, $this->_limitCount);
    }

    public function getSize()
    {
        return $this->_limitCount;
    }

    public function limit($limitCount)
    {
        $this->_limitCount = $limitCount;
    }

    public function offset($offsetCount)
    {
        $this->_offsetCount = $offsetCount;
    }
}
