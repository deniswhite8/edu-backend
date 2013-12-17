<?php

namespace App\Model;

class Address extends Entity {

    public function getCityId()
    {
        return $this->_getData('city_id');
    }

    public function getRegionId()
    {
        return $this->_getData('region_id');
    }

    public function getZipCode()
    {
        return $this->_getData('zip_code');
    }

    public function getStreet()
    {
        return $this->_getData('street');
    }

    public function getHouse()
    {
        return $this->_getData('house');
    }

    public function getFlat()
    {
        return $this->_getData('flat');
    }

    public function getId()
    {
        return $this->_getData('address_id');
    }

    public function load($id)
    {
        $this->_data = $this->_resource->find($id);
    }

    public function save()
    {
        $this->_resource->save($this->_data);
    }
}