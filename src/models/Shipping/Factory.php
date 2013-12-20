<?php
/**
 * Created by PhpStorm.
 * User: denis
 * Date: 19.12.13
 * Time: 20:12
 */

namespace App\Model\Shipping;


use Zend\Db\TableGateway\TableGateway;

class Factory
{
    private $_address;

    public function __construct(App\Model\Address $address)
    {
        $this->_address = $address;
    }

    public function getMethods()
    {
        return [new Fixed($this->_address), new TableRate($this->_address)];
    }
} 