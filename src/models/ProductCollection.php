<?php
namespace App\Model;

class ProductCollection implements \IteratorAggregate
{
    private $_resource;
    private $_prototype;

    public function __construct(Resource\IResourceCollection $resource, Product $productPrototype)
    {
        $this->_resource = $resource;
        $this->_prototype = $productPrototype;
    }

    public function getProducts()
    {
        return array_map(
            function ($data) {
                $product = clone $this->_prototype;
                $product->setData($data);
                return $product;
            },
            $this->_resource->fetch()
        );
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->getProducts());
    }

    public function sortBy($name, $reverse = false)
    {
        $this->_resource->sortBy($name, $reverse);
    }

    public function search($column, $string)
    {
        $this->_resource->likeBy($column, '%'.$string.'%');
    }
}