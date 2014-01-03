<?php

namespace App\Model;

class Admin extends Entity
{
    public function __construct(array $data, Resource\IResourceEntity $resource = null)
    {
        $hasher = new Hasher();
        if(isset($data['password']))
            $data['password'] = $hasher->hashed($data['password']);
        $this->_data = $data;
        $this->_resource = $resource;
    }

    public function getLogin()
    {
        return $this->getData('login');
    }
}