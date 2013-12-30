<?php


namespace App\Model;


class ProductOrderCollection implements \IteratorAggregate
{
    private $_resource;

    public function __construct(Resource\IResourceCollection $resource)
    {
        $this->_resource = $resource;
    }

    public function getProductsOrder()
    {
        return array_map(
            function ($data) {
                return new ProductOrder($data);
            },
            $this->_resource->fetch()
        );
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->getProductsOrder());
    }

    public function filterByOrder(Order $order)
    {
        $this->_resource->filterBy('order_id', $order->getId());
    }
}