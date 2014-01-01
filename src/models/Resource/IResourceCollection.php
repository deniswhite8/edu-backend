<?php
namespace App\Model\Resource;

interface IResourceCollection
{
    public function fetch();

    public function filterBy($column, $value);

    public function likeBy($column, $value);

    public function average($column);

    public function limit($limit, $offset = 0);

    public function sortBy($column, $reverse = false);

    public function count();
}
