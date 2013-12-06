<?php

namespace App\Controller;

use App\Model\Resource\Table\Product as ProductTable;
use App\Model\Session;
use App\Model\ShoppingCart;
use App\Model\Resource\Table\ShoppingCart as ShoppingCartTable;
use App\Model\Resource\DBCollection;
use App\Model\Resource\DBEntity;

class ShoppingCartController
{

    private function _getShoppingCart()
    {
        $connection = new \PDO('mysql:host=localhost;dbname=student', 'root', '123');
        $cartCollectionResource = new DBCollection($connection, new ShoppingCartTable);
        $cartEntityResource = new DBEntity($connection, new ShoppingCartTable);
        $productResource = new DBEntity($connection, new ProductTable);
        $shoppingCart = new ShoppingCart($cartEntityResource, $cartCollectionResource, $productResource, new Session());

        return $shoppingCart;
    }

    public function listAction()
    {
        $items = $this->_getShoppingCart()->getItems();

        $view = 'shoppingCart_list';
        require_once __DIR__ . '/../views/layout/main.phtml';
    }

    public function addAction()
    {
        $this->_getShoppingCart()->add($_GET['id']);
        $this->_goCart();
    }

    public function deleteAction()
    {
        $this->_getShoppingCart()->delete($_GET['id']);
        $this->_goCart();
    }

    public function plusAction()
    {
        $this->_getShoppingCart()->plus($_GET['id']);
        $this->_goCart();
    }

    public function minusAction()
    {
        $this->_getShoppingCart()->minus($_GET['id']);
        $this->_goCart();
    }

    private function _goCart()
    {
        echo '<script>location.href="/?page=shoppingCart_list"</script>';
    }
}