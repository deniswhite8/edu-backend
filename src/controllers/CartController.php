<?php
namespace App\Controller;

class CartController
    extends SalesController
{
    public function addAction()
    {
        $quoteItem = $this->_initQuoteItem();
        $quoteItem->addQty(1, 1);
        $quoteItem->save();

        $this->_redirect('cart_list');
    }

    public function plusAction()
    {
        $this->addAction();
    }

    public function minusAction()
    {
        $quoteItem = $this->_initQuoteItem();
        $quoteItem->addQty(1, -1);
        $quoteItem->save();

        $this->_redirect('cart_list');
    }

    public function deleteAction()
    {
        $quoteItem = $this->_initQuoteItem();
        $quoteItem->delete();

        $this->_redirect('cart_list');
    }

    public function listAction()
    {
        $quote = $this->_initQuote();
        $items = $quote->getItems();
        $items->assignProducts($this->_di->get('Product'));

        return $this->_di->get('View', [
            'template' => 'cart_list',
            'params'   => ['items' => $items]
        ]);
    }

    private function _initQuoteItem()
    {
        $quote = $this->_initQuote();

        $product = $this->_di->get('Product');
        $product->load($_GET['id']);

        $item = $quote->getItems()->forProduct($product);
        return $item;
    }

}