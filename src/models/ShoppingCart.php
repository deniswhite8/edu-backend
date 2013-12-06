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

    public function __construct(IResourceEntity $cartEntityResource, IResourceCollection $cartCollectionResource, IResourceEntity $productResource, Session $session)
    {
        $customer = $session->getCustomer();
        $this->_session = $session;
        $this->_cartCollectionResource = $cartCollectionResource;
        $this->_productResource = $productResource;
        $this->_cartEntityResource = $cartEntityResource;

        if (!isset($customer)) return;
        $this->_customerId = $customer->getId();

    }

    public function getItems()
    {
        $data = [];
        $resultArray = [];
        if (isset($this->_customerId)) {
            $this->_cartCollectionResource->filterBy('customer_id', $this->_customerId);
            $data = $this->_cartCollectionResource->fetch();

            foreach ($data as $i) {
                $product = new Product([]);
                $product->load($this->_productResource, $i['product_id']);
                $resultArray[] = ['product' => $product, 'count' => $i['count']];
            }
        } else {
            $data = $this->_session->get('cart');

            foreach ($data as $productId => $count) {
                $product = new Product([]);
                $product->load($this->_productResource, $productId);
                $resultArray[] = ['product' => $product, 'count' => $count];
            }
        }


        return $resultArray;
    }

    public function add($productId)
    {
        if (isset($this->_customerId)) {
            $this->_cartCollectionResource->filterBy('customer_id', $this->_customerId);
            $this->_cartCollectionResource->filterBy('product_id', $productId);
            $data = $this->_cartCollectionResource->fetch();

            if (count($data) == 0)
                $this->_cartEntityResource->save(
                    ['customer_id' => $this->_customerId, 'product_id' => $productId, 'count' => 1]);
            else {
                $this->_cartEntityResource->save(
                    ['shopping_cart_id' => reset($data)['shopping_cart_id'], 'customer_id' => $this->_customerId, 'product_id' => $productId,
                        'count' => intval(reset($data)['count']) + 1]);
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
            $data = $this->_cartCollectionResource->fetch();

            $this->_cartEntityResource->delete($data[0]['shopping_cart_id']);
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
            $data = $this->_cartCollectionResource->fetch();
            $data[0]['count'] = intval($data[0]['count']) - 1;
            $this->_cartEntityResource->save($data[0]);
        } else {
            $cart = $this->_session->get('cart');
            $cart[intval($productId)]--;
            $this->_session->set('cart', $cart);
        }
    }
}