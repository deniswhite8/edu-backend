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


    public function sendEmail(ProductOrderCollection $productOrderCollection, Customer $customer, ModelView $modelView)
    {
        $transport = new Smtp();
        $transport->setOptions(new SmtpOptions(
            [
                'host' => 'smtp.gmail.com',
                'connection_class' => 'plain',
                'connection_config' => [
                    'username' => '0test1337@gmail.com',
                    'password' => 'passwordfortest',
                    'ssl' => 'tls'
                ]
            ]
        ));

        $productOrderCollection->filterByOrder($this);
        $items = $productOrderCollection->getProductsOrder();

        $customer->load($this->getData('customer_id'));

        $modelView->setLayout(null);
        $modelView->set('created_at', $this->getData('created_at'));
        $modelView->set('number', $this->getData('number'));
        $modelView->set('shipping_method_code', $this->getData('shipping_method_code'));
        $modelView->set('payment_method_code', $this->getData('payment_method_code'));
        $modelView->set('shipping', $this->getData('shipping'));
        $modelView->set('subtotal', $this->getData('subtotal'));
        $modelView->set('grand_total', $this->getData('grand_total'));

        $modelView->set('region_name', $this->getData('region_name'));
        $modelView->set('city_name', $this->getData('city_name'));
        $modelView->set('zip_code', $this->getData('zip_code'));
        $modelView->set('street', $this->getData('street'));
        $modelView->set('house', $this->getData('house'));
        $modelView->set('flat', $this->getData('flat'));

        $modelView->set('customer', $customer);
        $modelView->set('items', $items);

        $message = new Message();
        $message->addTo('0test1337@gmail.com')
            ->addFrom('0test1337@gmail.com')
            ->setSubject('New order')
            ->setBody($modelView->renderToString());

        $transport->send($message);
    }
}
 