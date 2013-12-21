<?php

namespace App\Model\Shipping;

class TableRate implements IMethod
{
    private $_priceTable = ['1' => 9999, '2' => 99, '3' => 0];
    private $_code = 'table_rate';
    private $_address;

    public function __construct($address)
    {
        $this->_address = $address;
    }

    public function getPrice()
    {
        return $this->_priceTable[$this->_address->getCityId()];
    }

    public function getCode()
    {
        return $this->_code;
    }
}
 