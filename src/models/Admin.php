<?php

namespace App\Model;

class Admin extends Entity
{
    public function __construct(array $idata, Hasher $hasher, Resource\IResourceEntity $resource = null)
    {
        if(isset($idata['password']))
            $idata['password'] = $hasher->hashed($idata['password']);
        $this->_data = $idata;
        $this->_resource = $resource;
    }

    public function getLogin()
    {
        return $this->getData('login');
    }
}