<?php

namespace App\Model;

class AdminCollection implements \IteratorAggregate
{
    private $_resource;

    public function __construct(Resource\IResourceCollection $resource)
    {
        $this->_resource = $resource;
    }

    public function getAdmins()
    {
        return array_map(
            function ($data) {
                return new Admin($data);
            },
            $this->_resource->fetch()
        );
    }

    public function loginAttempt(Admin $admin)
    {
        $this->_resource->filterBy('login', $admin->getData('login'));
        $this->_resource->filterBy('password', $admin->getData('password'));
        $data = $this->_resource->fetch();
        if (count($data) == 0) return 0;
        else return $data[0]['admin_id'];
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->getAdmin());
    }
}