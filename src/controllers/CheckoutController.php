<?php

namespace App\Controller;

use App\Model\Product;
use App\Model\Quote\CollectorsFactory;

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
            $quote->setShippingMethod($_POST['method']);
            $this->_redirect('checkout_payment');
        } else {
            $quote = $this->_initQuote();
            $address = $quote->getAddress();

            $factory = $this->_di->get('Factory', ['address' => $address]);

            $methods = $factory->getMethods();

            $methodsArray = [];

            foreach ($methods as $method) {
                $methodsArray[] = ['code' => $method->getCode(), 'price' => $method->getPrice(), 'label' => $method->getLabel()];
            }

            return $this->_di->get('View', [
                'template' => 'checkout_shipping',
                'params' => ['methods' => $methodsArray]
            ]);
        }
    }


    public function paymentAction()
    {
        if (isset($_POST['method'])) {
            $quote = $this->_initQuote();
            $quote->setPaymentMethod($_POST['method']);
            $this->_redirect('checkout_order');
        } else {
            $quote = $this->_initQuote();
            $methods = $this->_di->get('PaymentFactory')
                ->getMethods()
                ->available($quote->getAddress());

            return $this->_di->get('View', [
                'template' => 'checkout_payment',
                'params' => ['methods' => $methods]
            ]);
        }
    }

    public function orderAction()
    {
        $productResource = $this->_di->get('ResourceEntity', ['table' => new \App\Model\Resource\Table\Product()]);
        $product = $this->_di->get('Product', ['resource' => $productResource]);


        $quote = $this->_initQuote($this->_di->get('CollectorsFactory', ['productPrototype' => $product]));
        $quote->collectTotals();
        $quote->save();

        if ($this->_isPost()) {
            $order = $this->_di->get('Order');
            $session = $this->_di->get('Session');
            $productOrder = $this->_di->get('ProductOrder');
            $quoteItemCollection = $this->_di->get('QuoteItemCollection');
            $city = $this->_di->get('City');
            $region = $this->_di->get('Region');

            $order->save();
            $this->_di->get('QuoteConverter')
                ->toOrder($quote, $order, $productOrder, $session, $quoteItemCollection, $product, $city, $region);
            $order->save();
            $order->sendEmail($this->_di->get('ProductOrderCollection'));
            $this->_redirect('product_list');
        } else {
            return $this->_di->get('View', [
                'template' => 'checkout_order',
                'params' => ['shipping' => $quote->getShipping(),
                             'subtotal' => $quote->getSubtotal(),
                             'grand_total' => $quote->getGrandTotal()]
            ]);
        }
    }
}
 