<?php
namespace App\Controller;

use App\Model\Customer;
use App\Model\Quote;
use App\Model\Session;
use App\Model\Resource\Table\QuoteItem as QuoteItemTable;

class CustomerController extends ActionController
{
    public function loginAction()
    {
        $error = false;
        if (isset($_POST['customer'])) {
            $session = $this->_di->get('Session');
            $guestQuoteId = $session->getQuoteId();

            $guestQuote = $this->_di->get('Quote');
            $guestQuote->loadBySession($session);

            $session->setQuoteId(null);

            if ($this->_loginCustomer($session)) {
                $quote = $this->_di->get('Quote');
                $quote->setField('quote_id', null);
                $quote->loadBySession($session);

                $this->_transfer($guestQuoteId, $quote->getId());

                $guestQuote->setField('quote_id', $guestQuoteId);
                $guestQuote->delete();

                $this->_redirect('product_list');
            } else {
                $error = true;
                $session->setQuoteId($guestQuoteId);
            }
        } else {
            $error = false;
        }

        return $this->_di->get('View', [
            'template' => 'customer_login',
            'params' => ['error' => $error]
        ]);
    }

    private function _transfer($quoteIdFrom, $quoteIdTo)
    {
        if(!isset($quoteIdFrom)) return;

        $resource = $this->_di->get('ResourceEntity', ['table' => new QuoteItemTable]);
        $quoteResourceSsid = $this->_di->get('ResourceCollection', ['table' => new QuoteItemTable]);
        $quoteResourceSsid->filterBy('quote_id', $quoteIdFrom);

        foreach ($quoteResourceSsid->fetch() as $quoteItem) {

            $quoteResource = $this->_di->get('ResourceCollection', ['table' => new QuoteItemTable]);
            $quoteResource->filterBy('quote_id', $quoteIdTo);
            $quoteResource->filterBy('product_id', $quoteItem['product_id']);
            $existItem = reset($quoteResource->fetch());

            if ($existItem) {
                $existItem['qty'] += $quoteItem['qty'];
                $resource->save($existItem);
            } else {
                $quoteItem['quote_id'] = $quoteIdTo;
                $resource->save($quoteItem);
            }
        }
    }

    public function registerAction()
    {
        $error = false;
        if (isset($_POST['customer'])) {
            if (!ctype_space($_POST['customer']['email']) && $_POST['customer']['password'] != '' && $this->_registerCustomer()) {


                $session = $this->_di->get('Session');
                $guestQuoteId = $session->getQuoteId();
                $guestQuote = $this->_di->get('Quote');
                $guestQuote->loadBySession($session);
                $session->setQuoteId(null);


                $this->_loginCustomer($session);



                $quote = $this->_di->get('Quote');
                $quote->setField('quote_id', null);
                $quote->loadBySession($session);
                $this->_transfer($guestQuoteId, $quote->getId());
                $guestQuote->setField('quote_id', $guestQuoteId);
                $guestQuote->delete();


                $this->_redirect('product_list');
            } else {
                $error = true;
            }
        } else {
            $error = false;
        }

        return $this->_di->get('View', [
            'template' => 'customer_register',
            'params' => ['error' => $error]
        ]);
    }

    public function logoutAction()
    {
        $session = new Session();
        $session->logout();
        $this->_redirect('product_list');
    }

    private function _registerCustomer()
    {
        $resource = $this->_di->get('ResourceEntity', ['table' => new \App\Model\Resource\Table\Customer()]);
        $customer = new Customer($_POST['customer'], $resource);

//        $customer = $this->_di->get('Customer', ['data' => $_POST['customer']]);

        try {
            $customer->save();
        } catch (\Exception $ex) {
            return false;
        }
        return true;
    }

    private function _loginCustomer(Session $session)
    {
        $customer = new Customer($_POST['customer']);

//        $customer = $this->_di->get('Customer', ['data' => $_POST['customer']]);
        $customers = $this->_di->get('CustomerCollection');

        $id = $customers->loginAttempt($customer);

        $session->login($id);

        return $session->isLoggedIn();
    }
}
