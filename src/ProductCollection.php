<?php

require_once __DIR__ . '/Collection.php';

class ProductCollection extends Collection
{
    public function getProducts()
    {
        return $this->_getData();
    }
}
