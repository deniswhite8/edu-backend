<?php

namespace App\Controller;

use App\Model\Address;

class CheckoutController
    extends SalesController
{

    public function addressAction()
    {
        if (isset($_POST['address'])) {
            $quote = $this->_initQuote();

            $address = $quote->getAddress();
            $address->setData($_POST['address']);
            $address->save();
            $this->_redirect('checkout_shipping');
        } else {
            $regions = $this->_di->get('RegionCollection');
            $regionNameArray = [];
            foreach ($regions->getRegions() as $region) {
                $regionNameArray[] = $region->getName();
            }

            $cities = $this->_di->get('CityCollection');
            $cityNameArray = [];
            foreach ($cities->getCities() as $city) {
                $cityNameArray[] = $city->getName();
            }

            $quote = $this->_initQuote();
            $address = $quote->getAddress();
            return $this->_di->get('View', [
                'template' => 'checkout_address',
                'params' => ['address' => $address, 'regions' => $regionNameArray, 'cities' => $cityNameArray]
            ]);
        }
    }

    public function shippingAction()
    {
        if (isset($_POST['method'])) {
            $quote = $this->_initQuote();
            $quote->setMethod($_POST['method']);
        } else {
            $quote = $this->_initQuote();
            $address = $quote->getAddress();

            $factory = $this->_di->get('Factory', ['address' => $address]);

            $methods = $factory->getMethods();

            $methodsArray = [];

            foreach ($methods as $method) {
                $methodsArray[] = ['code' => $method->getCode(), 'price' => $method->getPrice()];
            }

            return $this->_di->get('View', [
                'template' => 'checkout_shipping',
                'params' => ['methods' => $methodsArray]
            ]);
        }
    }

    public function paymentAction()
    {
        if (isset($_POST['payment'])) {

        } else {
            $quote = $this->_initQuote();
            $method = $this->_di->get('PaymentFactory')
                ->getMethods()
                ->available($quote->getAddres());
        }
    }

    public function orderAction()
    {
        $quote = $this->_initQuote();
        $quote->collectTotals();
        $quote->save();

        if ($this->_isPost()) {
            $order = $this->_di->get('Order');
            $this->_di->get('QuoteConverter')
                ->toOrder($quote, $order);
            $order->save();
            $order->sendEmail();
        } else {

        }
    }

    public function paymentAction()
    {
        if (isset($_POST['payment'])) {

        } else {
            $quote = $this->_initQuote();
            $methods = $this->_di->get('PaymentFactory')
                ->getMethods()
                ->available($quote->getAddress());
        }
    }

    public function orderAction()
    {
        $quote = $this->_initQuote();
        $quote->collectTotals();
        $quote->save();
        if ($this->_isPost()) {
            $order = $this->_di->get('Order');
            $this->_di->get('QuoteConverter')
                ->toOrder($quote, $order);
            $order->save();
            $order->sendEmail();
        } else {

        }
    }


}
 