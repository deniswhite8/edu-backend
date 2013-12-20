<?php

namespace App\Controller;


class SalesController extends ActionController
{
    protected function _getQuote()
    {
        $cartCollectionResource = $this->_di->get('ResourceCollection', ['table' => new \App\Model\Resource\Table\ShoppingCart()]);
        $cartEntityResource = $this->_di->get('ResourceEntity', ['table' => new \App\Model\Resource\Table\ShoppingCart()]);
        $productResource = $this->_di->get('ResourceEntity', ['table' => new \App\Model\Resource\Table\Product()]);
        $shoppingCart = new Quote($cartEntityResource, $cartCollectionResource, $productResource);

//        $shoppingCart = $this->_di->get('Quote');

        return $shoppingCart;
    }
}