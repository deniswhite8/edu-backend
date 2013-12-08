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
        if (isset($this->_customerId))
            $this->_cartCollectionResource->filterBy('customer_id', $this->_customerId);
        else
            $this->_cartCollectionResource->filterBy('session_id', $this->_session->getSessionId());
        return $this->_cartItemCollection->getItems();
    }

    public function add($productId)
    {
        $session_id = $this->_session->getSessionId();

        if (isset($this->_customerId))
            $this->_cartCollectionResource->filterBy('customer_id', $this->_customerId);
        else
            $this->_cartCollectionResource->filterBy('session_id', $session_id);

        $this->_cartCollectionResource->filterBy('product_id', $productId);
        $items = $this->_cartItemCollection->getItems();

        if (count($items)) {
            $items[0]->changeCount(+1);
            $items[0]->save($this->_cartEntityResource);
        } else {
            if (isset($this->_customerId))
                $item = new CartItem(['count' => 1, 'product_id' => $productId, 'customer_id' => $this->_customerId]);
            else
                $item = new CartItem(['count' => 1, 'product_id' => $productId, 'customer_id' => $this->_customerId,
                    'session_id' => $this->_session->getSessionId()]);
            $item->save($this->_cartEntityResource);
        }
    }

    public function delete($productId)
    {
        if (isset($this->_customerId))
            $this->_cartCollectionResource->filterBy('customer_id', $this->_customerId);
        else
            $this->_cartCollectionResource->filterBy('session_id', $this->_session->getSessionId());
        $this->_cartCollectionResource->filterBy('product_id', $productId);
        $item = $this->_cartItemCollection->getItems()[0];
        $item->delete($this->_cartEntityResource);
    }


    public function plus($productId)
    {
        $this->add($productId);
    }

    public function minus($productId)
    {
        if (isset($this->_customerId))
            $this->_cartCollectionResource->filterBy('customer_id', $this->_customerId);
        else
            $this->_cartCollectionResource->filterBy('session_id', $this->_session->getSessionId());
        $this->_cartCollectionResource->filterBy('product_id', $productId);
        $item = $this->_cartItemCollection->getItems()[0];
        $item->changeCount(-1);
        $item->save($this->_cartEntityResource);
    }
}