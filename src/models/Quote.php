<?php
namespace App\Model;


class Quote
    extends Entity
{
    private $_items;
    private $_address;
    private $_collectorsFactory;

    public function __construct(
        array $data = [],
        Resource\IResourceEntity $resource = null,
        QuoteItemCollection $items = null,
        Address $address = null,
        Quote\CollectorsFactory $collectorsFactory = null
    ) {
        $this->_items = $items;
        $this->_address = $address;
        $this->_collectorsFactory = $collectorsFactory;
        parent::__construct($data, $resource);
    }

    public function getQuoteItemsCollection()
    {
        return $this->_items;
    }

    public function loadBySession(Session $session)
    {
        if ($quoteId = $session->getQuoteId()) {
            $this->load($session->getQuoteId());
        } else {
            $this->save();
            $session->setQuoteId($this->getId());
        }
    }

    public function getItems()
    {
        $this->_items->filterByQuote($this);
        return $this->_items;
    }

    public function getAddress()
    {
        if ($addressId = $this->getData('address_id')) {
            $this->_address->load($this->getData('address_id'));
        } else {
            $this->_address->save();
            $this->_assignAddress();
        }
        return $this->_address;
    }

    public function setShippingMethod($code)
    {
        $this->setField('shipping_method_code', $code);
        $this->save();
    }

    public function getShippingMethod()
    {
        return $this->getData('shipping_method_code');
    }

    public function setPaymentMethod($code)
    {
        $this->setField('payment_method_code', $code);
        $this->save();
    }

    protected function _assignAddress()
    {
        $this->_data['address_id'] = $this->_address->getId();
        $this->save();
    }

    public function collectTotals()
    {
        foreach ($this->_collectorsFactory->getCollectors() as $field => $collector) {
            $this->_data[$field] = $collector->collect($this);
        }
    }

    public function getSubtotal()
    {
        return $this->getData('subtotal');
    }

    public function getShipping()
    {
        return $this->getData('shipping');
    }

    public function getGrandTotal()
    {
        return $this->getData('grand_total');
    }
}