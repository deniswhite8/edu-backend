<?php
namespace App\Model;

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

    public function getEmail()
    {
        return $this->getData('email');
    }

    public function getName()
    {
        return $this->getData('name');
    }

    public function load($id)
    {
        $this->_data = $this->_resource->find($id);
    }

    public function getQuoteId()
    {
        return isset($this->_data['quote_id']) ? $this->_data['quote_id'] : null;
    }

    public function setQuoteId($id)
    {
        $this->_data['quote_id'] = $id;
        $this->save();
    }
}
