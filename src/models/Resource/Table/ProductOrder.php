<?php
namespace App\Model\Resource\Table;
class ProductOrder implements ITable
{
    public function getName()
    {
        return 'products_order';
    }

    public function getPrimaryKey()
    {
        return 'products_order_id';
    }
}