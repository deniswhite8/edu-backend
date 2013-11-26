<?php

require_once __DIR__ . '/Collection.php';
require_once __DIR__ . '/Resource/IResourceCollection.php';

class ProductCollection extends Collection
{
    public function getProducts()
    {
        return array_map(
            function ($data) {
                return new Product($data);
            },
            $this->_resource->fetch()
        );
    }

    public function getIterator()
    {
        return new ArrayIterator($this->getProducts());
    }
}
