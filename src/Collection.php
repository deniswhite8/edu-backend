<?php
/**
 * Created by PhpStorm.
 * User: denis
 * Date: 01.11.13
 * Time: 15:50
 */

class Collection implements Iterator {
    private $_data = array();
    private $_offsetCount, $_limitCount;

    public function __construct($data)
    {
        $this->_data = $data;
        $this->_offsetCount = 0;
        $this->_limitCount = count($this->_data);
    }

    protected function _getData()
    {
        return array_slice($this->_data, $this->_offsetCount, $this->_limitCount);
    }

    protected function _getSize()
    {
        return count($this->_getData());
    }

    protected function _limit($limitCount)
    {
        $this->_limitCount = $limitCount;
    }

    protected function _offset($offsetCount)
    {
        $this->_offsetCount = $offsetCount;
    }


    // Iterator function

    public function rewind()
    {
        reset($this->_data);
    }

    public function current()
    {
        $var = current($this->_data);
        return $var;
    }

    public function key()
    {
        $var = key($this->_data);
        return $var;
    }

    public function next()
    {
        $var = next($this->_data);
        return $var;
    }

    public function valid()
    {
        $key = key($this->_data);
        $var = ($key !== null && $key !== false);
        return $var;
    }
}