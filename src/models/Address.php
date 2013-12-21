<?php

namespace App\Model;

class Address extends Entity {

    public function getCityId()
    {
        return $this->getData('city_id');
    }

    public function getRegionId()
    {
        return $this->getData('region_id');
    }

    public function getZipCode()
    {
        return $this->getData('zip_code');
    }

    public function getStreet()
    {
        return $this->getData('street');
    }

    public function getHouse()
    {
        return $this->getData('house');
    }

    public function getFlat()
    {
        return $this->getData('flat');
    }

    public function getId()
    {
        return $this->getData('address_id');
    }

//    public function load($id)
//    {
//        $this->_data = $this->_resource->find($id);
//    }
//
//    public function save()
//    {
//        $this->_resource->save($this->_data);
//    }
}