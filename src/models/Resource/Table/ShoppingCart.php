<?php
namespace App\Model\Resource\Table;
class ShoppingCart implements ITable
{
    public function getName()
    {
        return 'shopping_cart';
    }

    public function getPrimaryKey()
    {
        return 'shopping_cart_id';
    }
}
  