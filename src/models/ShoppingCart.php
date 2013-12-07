<?php

namespace App\Model;

use App\Model\Resource\IResourceCollection;
use App\Model\Resource\IResourceEntity;

class ShoppingCart
{
    private $_customerId;
    private $_cartCollectionResource;
    private $_cartEntityResource;
    private $_productResource;
    private $_session;
    private $_cartItemCollection;

    public function __construct(IResourceEntity $cartEntityResource, IResourceCollection $cartCollectionResource, IResourceEntity $productResource, Session $session)
    {
        $customer = $session->getCustomer();
        $this->_session = $session;
        $this->_cartCollectionResource = $cartCollectionResource;
        $this->_productResource = $productResource;
        $this->_cartEntityResource = $cartEntityResource;
        $this->_cartItemCollection = new CartItemCollection($cartCollectionResource, $productResource);

        if (!isset($customer)) return;
        $this->_customerId = $customer->getId();

    }

    public function getItems()
    {
        if (isset($this->_customerId)) {
            $this->_cartCollectionResource->filterBy('customer_id', $this->_customerId);
            return $this->_cartItemCollection->getItems();
        } else {
            $data = $this->_session->get('cart');
            $resultArray = [];
            foreach ($data as $productId => $count) {
                $product = new Product([]);
                $product->load($this->_productResource, $productId);
                $item = new CartItem(['product_id' => $productId, 'count' => $count]);
                $item->product = $product;
                $resultArray[] = $item;
            }

            return $resultArray;
        }
    }

    public function add($productId)
    {
        if (isset($this->_customerId)) {

            $this->_cartCollectionResource->filterBy('customer_id', $this->_customerId);
            $this->_cartCollectionResource->filterBy('product_id', $productId);
            $items = $this->_cartItemCollection->getItems();

            if(count($items)) {
                $items[0]->changeCount(+1);
                $items[0]->save($this->_cartEntityResource);
            } else {
                $item = new CartItem(['count' => 1, 'product_id' => $productId, 'customer_id' => $this->_customerId]);
                $item->save($this->_cartEntityResource);
            }
        } else {
            $cart = $this->_session->get('cart');
            if (!isset($cart)) $cart = [];
            if (isset($cart[$productId])) $cart[$productId]++;
            else $cart[$productId] = 1;
            $this->_session->set('cart', $cart);
        }
    }

    public function delete($productId)
    {
        if (isset($this->_customerId)) {
            $this->_cartCollectionResource->filterBy('customer_id', $this->_customerId);
            $this->_cartCollectionResource->filterBy('product_id', $productId);
            $item = $this->_cartItemCollection->getItems()[0];
            $item->delete($this->_cartEntityResource);
        } else {
            $cart = $this->_session->get('cart');
            unset($cart[intval($productId)]);
            $this->_session->set('cart', $cart);
        }
    }


    public function plus($productId)
    {
        $this->add($productId);
    }

    public function minus($productId)
    {
        if (isset($this->_customerId)) {
            $this->_cartCollectionResource->filterBy('customer_id', $this->_customerId);
            $this->_cartCollectionResource->filterBy('product_id', $productId);
            $item = $this->_cartItemCollection->getItems()[0];
            $item->changeCount(-1);
            $item->save($this->_cartEntityResource);
        } else {
            $cart = $this->_session->get('cart');
            $cart[intval($productId)]--;
            $this->_session->set('cart', $cart);
        }
    }
}