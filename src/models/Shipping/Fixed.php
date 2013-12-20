<?php

namespace App\Model\Shipping;

class Fixed implements IMethod
{
    public function getPrice()
    {
        return 42;
    }
}