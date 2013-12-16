<?php
namespace App\Model;
use App\Model\Resource\IResourceEntity;

class Customer extends Entity
{
    public function __construct(array $data, Resource\IResourceEntity $resource = null)
    {
        $hasher = new Hasher();
        if(isset($data['password']))
            $data['password'] = $hasher->hashed($data['password']);
        $this->_data = $data;
        $this->_resource = $resource;
    }

    public function save()
    {
        $id = $this->_resource->save($this->_data);
        $this->_data['customer_id'] = $id;
    }

    public function getId()
    {
        return $this->_getData('customer_id');
    }

    public function load($id)
    {
        $this->_data = $this->_resource->find($id);
    }
}
