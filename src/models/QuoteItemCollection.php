<?php

namespace App\Model;

class QuoteItemCollection implements \IteratorAggregate
{
    private $_resource;
    private $_productResource;
    private $_quoteItemResource;

    public function __construct(Resource\IResourceCollection $resource, Resource\IResourceEntity $productResource, Resource\IResourceEntity $quoteItemResource)
    {
        $this->_resource = $resource;
        $this->_productResource = $productResource;
        $this->_quoteItemResource = $quoteItemResource;
    }

    public function getItems()
    {
        return array_map(
            function ($data) {
                $item = new QuoteItem($data, $this->_quoteItemResource);
                $product = new Product([], $this->_productResource);
                $product->load($item->getProductId());
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