<?php

namespace App\Model;

class CartItemCollection implements \IteratorAggregate
{
    private $_resource;
    private $_productResource;

    public function __construct(Resource\IResourceCollection $resource, Resource\IResourceEntity $productResource)
    {
        $this->_resource = $resource;
        $this->_productResource = $productResource;
    }

    public function getItems()
    {
        return array_map(
            function ($data) {
                $item = new CartItem($data);
                $product = new Product([]);
                $product->load($this->_productResource, $item->getProductId());
                $item->product = $product;
                return $item;
            },
            $this->_resource->fetch()
        );
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->getItems());
    }
}