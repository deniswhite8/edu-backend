<?php
namespace App\Controller;

class SalesController
    extends ActionController
{

    protected function _initQuote($collectorFactory = null)
    {
        $quote   = $this->_di->get('Quote', ['collectorsFactory' => $collectorFactory]);
        $session = $this->_di->get('Session');

        $quote->loadBySession($session);

        return $quote;
    }
}