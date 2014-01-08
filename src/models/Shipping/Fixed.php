<?php

namespace App\Model\Shipping;

class Fixed implements IMethod
{
    private $_price = 3.02;
    private $_code = 'fixed';

    public function getPrice()
    {
        return $this->_price;
    }

    public function getCode()
    {
        return $this->_code;
    }

    public function getLabel()
    {
        return 'Fixed';
    }
}
 