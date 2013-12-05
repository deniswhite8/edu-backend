<?php
namespace App\Model;

use App\Model\Resource\IResourceEntity;

class Customer extends Entity
{
    public function save(IResourceEntity $resource)
    {
        $resource->save($this->_data);
    }

    public function getId()
    {
        return $this->_getData('customer_id');
    }
}
