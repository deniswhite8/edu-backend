<?php

namespace App\Model;

class Hasher
{
    private $_salt = 'sugar';

    public function hashed($str)
    {
        for($i = 0; $i < 10; $i++) {
            $str = md5($this->_salt . $str . $this->_salt);
        }
        return $str;
    }
}