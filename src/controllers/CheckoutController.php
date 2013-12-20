<?php

namespace App\Controller;


class CheckoutController extends SalesController
{
    public function addAddressAction()
    {
        if (isset($_POST['address'])) {
            $quote = $this->_getQuote();
            $address = $quote->getAddress();
            $address->setData($_POST['address']);
            $address->save();
            $this->_redirect('setShipping');
        }
    }

    public function shippingAction()
    {

    }
} 