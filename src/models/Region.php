<?php

namespace App\Model;

class Region extends Entity
{
    public function load($id)
    {
        $this->_data = $this->_resource->find($id);
    }

    public function save()
    {
        $this->_resource->save($this->_data);
    }

    public function getId()
    {
        return $this->getData('region_id');
    }

    public function getName()
    {
        return $this->getData('name');
    }
}