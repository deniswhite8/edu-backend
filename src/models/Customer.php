<?php
namespace App\Model;

class Customer extends Entity
{

    public function __construct(array $idata, Hasher $hasher, Resource\IResourceEntity $resource = null)
    {
        if(isset($idata['password']))
            $idata['password'] = $hasher->hashed($idata['password']);
        $this->_data = $idata;
        $this->_resource = $resource;
    }

    public function getEmail()
    {
        return $this->getData('email');
    }

    public function getName()
    {
        return $this->getData('name');
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
