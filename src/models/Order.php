<?php

namespace App\Model;

use Zend\Mail\Message;
use Zend\Mail\Transport\Smtp as SmtpTransport;
use Zend\Mail\Transport\Smtp;
use Zend\Mail\Transport\SmtpOptions;

class Order extends Entity
{
    public function setCustomerId($customerId)
    {
        $this->setField('customer_id', $customerId);
    }

    public function setShippingMethod($shippingMethod)
    {
        $this->setField('shipping_method_code', $shippingMethod);
    }

    public function setPaymentMethod($paymentMethod)
    {
        $this->setField('payment_method_code', $paymentMethod);
    }


    public function setTotals($shipping, $subtotal, $total)
    {
        $this->setField('shipping', $shipping);
        $this->setField('subtotal', $subtotal);
        $this->setField('grand_total', $total);
    }


    public function sendEmail(ProductOrderCollection $productOrderCollection)
    {
        $transport = new Smtp();
        $transport->setOptions(new SmtpOptions(
            [
                'host' => 'smtp.gmail.com',
                'connection_class' => 'plain',
                'connection_config' => [
                    'username' => 'deniswhite8@gmail.com',
                    'password' => 'nope :3',
                    'ssl' => 'tls'
                ]
            ]
        ));

        $productOrderCollection->filterByOrder($this);
        $items = $productOrderCollection->getProductsOrder();

        $productsMessage = '';
        $i = 0;
        foreach ($items as $productOrder) {
            $productsMessage .= "#{$i}\n";

            $productsMessage .= "Qty: {$productOrder->getData('qty')}\n";
            $productsMessage .= "Name: {$productOrder->getData('name')}\n";
            $productsMessage .= "Sku: {$productOrder->getData('sku')}\n";
            $productsMessage .= "Price: {$productOrder->getData('price')}\n";
            $productsMessage .= "Special price: {$productOrder->getData('special_price')}\n";

            $productsMessage .= "\n";
            $i++;
        }


        $message = new Message();
        $message->addTo('deniswhite8@gmail.com')
            ->addFrom('deniswhite8@gmail.com')
            ->setSubject('New order')
            ->setBody(
                      "~ New order ~\n" .
                      "Shipping method code: {$this->getData('shipping_method_code')}\n" .
                      "Payment method code: {$this->getData('payment_method_code')}\n" .
                      "Shipping: {$this->getData('shipping')}\n" .
                      "Subtotal: {$this->getData('subtotal')}\n" .
                      "Grand total: {$this->getData('grand_total')}\n\n" .

                      "~ Address ~\n" .
                      "Region: {$this->getData('region_name')}\n" .
                      "City: {$this->getData('city_name')}\n" .
                      "Zip code: {$this->getData('zip_code')}\n" .
                      "Street: {$this->getData('street')}\n" .
                      "House: {$this->getData('house')}\n" .
                      "Flat: {$this->getData('flat')}\n\n" .

                      "~ Products ~\n" .
                      $productsMessage
            );
        $transport->send($message);
    }
}
 