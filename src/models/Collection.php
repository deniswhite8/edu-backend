<?php
/**
 * Created by PhpStorm.
 * User: denis
 * Date: 01.11.13
 * Time: 15:50
 */

abstract class Collection implements IteratorAggregate {

    protected $_resource;

    public function __construct(IResourceCollection $resource)
    {
        $this->_resource = $resource;
    }

    public function getIterator()
    {

    }
}