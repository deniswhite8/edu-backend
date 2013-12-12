<?php

namespace App\Controller;

use App\Model\Resource\Table\Product as ProductTable;
use App\Model\Session;
use App\Model\Quote;
use App\Model\Resource\Table\ShoppingCart as ShoppingCartTable;
use App\Model\Resource\DBCollection;
use App\Model\Resource\DBEntity;

class QuoteController
{

    private function _getQuote()
    {
        $connection = new \PDO('mysql:host=localhost;dbname=student', 'root', '123');
        $cartCollectionResource = new DBCollection($connection, new ShoppingCartTable);
        $cartEntityResource = new DBEntity($connection, new ShoppingCartTable);
        $productResource = new DBEntity($connection, new ProductTable);
        $shoppingCart = new Quote($cartEntityResource, $cartCollectionResource, $productResource);

        return $shoppingCart;
    }

    public function listAction()
    {
        $quote = $this->_getQuote();
        $session = new Session();

        $items = null;
        if ($session->isLoggedIn())
            $items = $quote->loadByCustomer($session->getCustomer());
        else
            $items = $quote->loadBySession($session);


        $view = 'quote_list';
        require_once __DIR__ . '/../views/layout/base.phtml';
    }

    public function addAction()
    {
        $quote = $this->_getQuote();
        $session = new Session();

        if ($session->isLoggedIn())
            $quote->addToCustomer($_GET['id'], $session->getCustomer(), 1);
        else
            $quote->addToSession($_GET['id'], $session, 1);

        $this->_goCart();
    }

    public function deleteAction()
    {
        $quote = $this->_getQuote();
        $session = new Session();

        if ($session->isLoggedIn())
            $quote->deleteFromCustomer($_GET['id'], $session->getCustomer());
        else
            $quote->deleteFromSession($_GET['id'], $session);

        $this->_goCart();
    }

    public function plusAction()
    {
        $this->addAction();
        $this->_goCart();
    }

    public function minusAction()
    {
        $quote = $this->_getQuote();
        $session = new Session();

        if ($session->isLoggedIn())
            $quote->addToCustomer($_GET['id'], $session->getCustomer(), -1);
        else
            $quote->addToSession($_GET['id'], $session, -1);
        $this->_goCart();
    }

    private function _goCart()
    {
        echo '<script>location.href="/?page=quote_list"</script>';
    }
}