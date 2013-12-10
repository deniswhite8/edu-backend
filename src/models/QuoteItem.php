<?php

namespace App\Model;

use App\Model\Resource\IResourceEntity;

class QuoteItem extends Entity
{
    public $product;

    public function getProductId()
    {
        return $this->_getData('product_id');
    }

    public function getCustomerId()
    {
        return $this->_getData('customer_id');
    }

    public function getCount()
    {
        return $this->_getData('count');
    }

    public function changeCount($d)
    {
        $this->_data['count'] += $d;
    }

    public function getId()
    {
        return $this->_getData('shopping_cart_id');
    }

    public function save(IResourceEntity $resource)
    {
        $id = $resource->save($this->_data);
        $this->_data['shopping_cart_id'] = $id;
    }

    public function delete(IResourceEntity $resource)
    {
        $resource->delete($this->getId());
    }

    public function load(IResourceEntity $resource, $id)
    {
        $this->_data = $resource->find($id);
    }
}