<?php

namespace App\Model;

class City extends Entity
{
    public function getId()
    {
        return $this->getData('ciy_id');
    }

    public function getName()
    {
        return $this->getData('name');
    }

    public function getRegionId()
    {
        return $this->getData('region_id');
    }
}