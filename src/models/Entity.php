<?php

namespace App\Model;

class Entity
{
    protected $_data = array();
    protected $_resource;

    public function __construct(array $data = [], Resource\IResourceEntity $resource = null)
    {
        $this->_data = $data;
        $this->_resource = $resource;
    }

    public function getData($key)
    {
        return isset($this->_data[$key]) ? $this->_data[$key] : null;
    }

    public function setData($data)
    {
        if(! $this->_resource) {
            $this->_data = $data;
            return;
        }
        $primaryKeyField = $this->_resource->getPrimaryKeyField();
        $id = $this->getId();
        $this->_data = $data;
        if($id && !isset($data[$primaryKeyField])) $this->_data[$primaryKeyField] = $id;
    }

    public function setField($key, $value)
    {
        $this->_data[$key] = $value;
    }

    public function load($id)
    {
        $this->_data = $this->_resource->find($id);
    }

    public function save()
    {
        $id = $this->_resource->save($this->_data);
        $this->_data[$this->_resource->getPrimaryKeyField()] = $id;
    }

    public function delete()
    {
        $this->_resource->delete($this->getId());
    }

    public function getId()
    {
        return $this->getData($this->_resource->getPrimaryKeyField());
    }
}
