<?php
/**
 * Created by PhpStorm.
 * User: denis
 * Date: 01.11.13
 * Time: 15:50
 */

class Collection implements IteratorAggregate {
    private $_data = array();
    private $_offsetCount, $_limitCount;
    private $_position = 0;

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

    protected function _getAllData()
    {
        return $this->_data;
    }

    public function getSize()
    {
        return count($this->_getData());
    }

    public function limit($limitCount)
    {
        $this->_limitCount = $limitCount;
    }

    public function offset($offsetCount)
    {
        $this->_offsetCount = $offsetCount;
    }

    public function sort($key)
    {
        $cmp = function($first, $second) use ($key)
        {
            $a = $first->getField($key);
            $b = $second->getField($key);

            if($a == $b) return 0;
            return ($a < $b) ? -1 : 1;
        };
        usort($this->_data, $cmp);
    }

    // Iterator function
    public function getIterator()
    {
        return new ArrayIterator($this->_getData());
    }
}