<?php
/**
 * Created by PhpStorm.
 * User: denis
 * Date: 01.11.13
 * Time: 14:09
 */

class Сontainer {
    private $_data = array();

    public function __construct(array $data)
    {
        $this->_data = $data;
    }

    public function getField($key)
    {
        return isset($this->_data[$key]) ? $this->_data[$key] : null;
    }

    public function setField($key, $value)
    {
        $this->_data[$key] = $value;
    }
} 