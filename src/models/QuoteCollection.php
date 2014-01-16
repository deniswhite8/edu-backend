<?php
namespace App\Model;

class QuoteCollection implements \IteratorAggregate
{
    private $_resource;
    private $_prototype;

    public function __construct(Resource\IResourceCollection $resource, Quote $itemPrototype)
    {
        $this->_resource = $resource;
        $this->_prototype = $itemPrototype;
    }

    public function filterByCustomerId($customerId)
    {
        $this->_resource->filterBy('customer_id', $customerId);
    }

    public function filterBySessionId($sessionId)
    {
        $this->_resource->filterBy('session_id', $sessionId);
    }

    public function setLast()
    {
        $this->_resource->sortBy('quote_id', true);
        $this->_resource->limit(1);
    }

    public function getQuotes()
    {
        return array_map(
            function ($data) {
                $item = clone $this->_prototype;
                $item->setData($data);
                return $item;
            },
            $this->_resource->fetch()
        );
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->getQuotes());
    }

    public function clear()
    {
        $this->_resource->clearFilters();
    }
}
