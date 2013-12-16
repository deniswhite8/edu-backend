<?php

namespace App\Controller;

use App\Model\Controller;
use App\Model\Resource\Table\Product as ProductTable;
use App\Model\Session;
use App\Model\Quote;
use App\Model\Resource\Table\ShoppingCart as ShoppingCartTable;
use App\Model\Resource\DBCollection;
use App\Model\Resource\DBEntity;

class QuoteController extends Controller
{

    private function _getQuote()
    {
        $cartCollectionResource = $this->_di->get('ResourceCollection', ['table' => new \App\Model\Resource\Table\ShoppingCart()]);
        $cartEntityResource = $this->_di->get('ResourceEntity', ['table' => new \App\Model\Resource\Table\ShoppingCart()]);
        $productResource = $this->_di->get('ResourceEntity', ['table' => new \App\Model\Resource\Table\Product()]);
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

        return $this->_di->get('View', [
            'template' => 'quote_list',
            'params'   => ['items' => $items]
        ]);
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