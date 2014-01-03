<?php

namespace App\Model;

class Region extends Entity
{
    public function getId()
    {
        return $this->getData('region_id');
    }

    public function getName()
    {
        return $this->getData('name');
    }
}