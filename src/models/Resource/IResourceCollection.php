<?php

interface IResourceCollection
{
    public function fetch();
    public function whereEqual($field, $val);
    public function avg($avgfield);
    public function avgWithWhereEqual($avgfield, $field, $val);
}