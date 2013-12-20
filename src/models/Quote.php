<?php

namespace App\Model;

use App\Model\Resource\IResourceCollection;
use App\Model\Resource\IResourceEntity;

class Quote
{
    private $_cartCollectionResource;
    private $_cartEntityResource;
    private $_cartItemCollection;

    public function __construct(IResourceEntity $cartEntityResource, IResourceCollection $cartCollectionResource, IResourceEntity $productResource)
    {
        $this->_cartCollectionResource = $cartCollectionResource;
        $this->_cartEntityResource = $cartEntityResource;
        $this->_cartItemCollection = new QuoteItemCollection($cartCollectionResource, $productResource, $cartEntityResource);
    }

    public function loadBySession(Session $session)
    {
        $this->_cartCollectionResource->filterBy('session_id', $session->getSessionId());
        return $this->_cartItemCollection->getItems();
    }

    public function loadByCustomer(Customer $customer)
    {
        $this->_cartCollectionResource->filterBy('customer_id', $customer->getId());
        return $this->_cartItemCollection->getItems();
    }

    public function getItemForProduct($productId)
    {
        $this->_cartCollectionResource->filterBy('product_id', $productId);
        $items = $this->_cartItemCollection->getItems();

        if (count($items)) {
            return $items[0];
        } else {
            return null;
        }
    }

    public function addToCustomer($productId, Customer $customer, $count)
    {
        $this->_add($productId, $count, $customer, null);
    }

    public function addToSession($productId, Session $session, $count)
    {
        $this->_add($productId, $count, null, $session);
    }

    public function deleteFromCustomer($productId, Customer $customer)
    {
        $this->_delete($productId, $customer, null);
    }

    public function deleteFromSession($productId, Session $session)
    {
        $this->_delete($productId, null, $session);
    }

    private function _delete($productId, $customer, $session)
    {
        if (isset($customer))
            $this->_cartCollectionResource->filterBy('customer_id', $customer->getId());
        else if (isset($session))
            $this->_cartCollectionResource->filterBy('session_id', $session->getSessionId());
        else
            throw new \Exception('Not Customer and not Session!');


        $this->_cartCollectionResource->filterBy('product_id', $productId);
        $item = $this->_cartItemCollection->getItems()[0];
        $item->delete($this->_cartEntityResource);
    }

    private function _add($productId, $count, $customer, $session)
    {
        if (isset($customer))
            $this->_cartCollectionResource->filterBy('customer_id', $customer->getId());
        else if (isset($session))
            $this->_cartCollectionResource->filterBy('session_id', $session->getSessionId());
        else
            throw new \Exception('Not Customer and not Session!');

        $this->_cartCollectionResource->filterBy('product_id', $productId);
        $item = $this->_cartItemCollection->getItems()[0];

        if (isset($item)) {

            if ($item->getCount() + $count < 1) return;

            $item->changeCount($count);
        } else {
            if (isset($customer))
                $item = new QuoteItem(
                    ['count' => 1, 'product_id' => $productId, 'customer_id' => $customer->getId()], $this->_cartEntityResource);
            else if (isset($session))
                $item = new QuoteItem(['count' => 1, 'product_id' => $productId,
                    'session_id' => $session->getSessionId()], $this->_cartEntityResource);
            else
                throw new \Exception('Not Customer and not Session!');
        }
        $item->save($this->_cartEntityResource);
    }


    public function getAddress()
    {
        if ($addressId = $this->_getData('address_id')) {
            return $this->_address->load($this->_getData('address_id'));
        } else {
            $this->_address->save();
            $this->_assignAddress();
            return $this->_addres;
        }
    }

    protected function _assignAddress()
    {
        $this->_data['address_id'] = $this->_address->getId();
        $this->save();
    }
}