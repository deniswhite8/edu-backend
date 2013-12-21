<?php

namespace App\Model\Shipping;

class Fixed implements IMethod
{
    private $_price = 42;
    private $_code = 'fixed';
    private $_address;

    public function __construct($address)
    {
        $this->_address = $address;
    }

    public function getPrice()
    {
        return $this->_price;
    }

    public function getCode()
    {
        return $this->_code;
    }
}
 