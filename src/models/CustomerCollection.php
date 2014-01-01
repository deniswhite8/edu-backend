<?php

namespace App\Model;

class CustomerCollection
    implements \IteratorAggregate
{
    private $_resource;

    public function __construct(Resource\IResourceCollection $resource)
    {
        $this->_resource = $resource;
    }

    public function getCustomers()
    {
        return array_map(
            function ($data) {
                return new Customer($data);
            },
            $this->_resource->fetch()
        );
    }

    public function loginAttempt(Customer $customer)
    {
        $this->_resource->filterBy('email', $customer->getData('email'));
        $this->_resource->filterBy('password', $customer->getData('password'));
        $data = $this->_resource->fetch();
        if (count($data) == 0) return 0;
        else return $data[0]['customer_id'];
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->getCustomers());
    }
}