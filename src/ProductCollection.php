<?php

require_once __DIR__ . '/Collection.php';

class ProductCollection extends Collection
{
    public function getProducts()
    {
        return $this->_getData();
    }

    public function getSize() {
        return $this->_getSize();
    }

    public function limit($limitCount) {
        $this->_limit($limitCount);
    }

    public function offset($offsetCount) {
        $this->_offset($offsetCount);
    }
}
