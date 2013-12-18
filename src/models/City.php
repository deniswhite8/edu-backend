<?php

namespace App\Model;

class City extends Entity
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
        return $this->_getData('ciy_id');
    }

    public function getName()
    {
        return $this->_getData('name');
    }

    public function getRegionId()
    {
        return $this->_getData('region_id');
    }
}