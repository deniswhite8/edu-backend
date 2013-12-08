<?php
namespace App\Model;
use App\Model\Resource\IResourceEntity;

class Customer extends Entity
{
    public function __construct(array $data)
    {
        $hasher = new Hasher();
        if(isset($data['password']))
            $data['password'] = $hasher->hashed($data['password']);
        $this->_data = $data;
    }

    public function save(IResourceEntity $resource)
    {
        $id = $resource->save($this->_data);
        $this->_data['customer_id'] = $id;
    }

    public function getId()
    {
        return $this->_getData('customer_id');
    }

    public function load(Resource\IResourceEntity $resource, $id)
    {
        $this->_data = $resource->find($id);
    }
}
