<?php
namespace App\Model;


class Quote
    extends Entity
{
    private $_items;
    private $_address;

    public function __construct(
        array $data = [],
        Resource\IResourceEntity $resource = null,
        QuoteItemCollection $items = null,
        Address $address = null,
        Quote\CollectorsFactory $collectorsFactory
    ) {
        $this->_items = $items;
        $this->_address = $address;
        parent::__construct($data, $resource);
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

    public function setMethod($code)
    {
        $this->setField('method_code', $code);
        $this->save();
    }

    protected function _assignAddress()
    {
        $this->_data['address_id'] = $this->_address->getId();
        $this->save();
    }

    public function collectTotal()
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

    public function getTotal()
    {
        return $this->getData('total');
    }
}