<?php
namespace App\Controller;

use App\Model\Controller;
use App\Model\CustomerCollection;
use App\Model\Resource\DBCollection;
use App\Model\Resource\DBEntity;
use App\Model\Customer;
use App\Model\Resource\Table\Customer as CustomerTable;
use App\Model\Session;

class CustomerController extends ActionController
{
    public function loginAction()
    {
        $error = false;
        $again = false;
        if (isset($_POST['customer'])) {
            if ($this->_loginCustomer()) $this->_redirect('product_list');
            else {
                $error = true;
                $again = true;
            }
        } else {
            $error = false;
            $again = true;
        }

        return $this->_di->get('View', [
            'template' => 'customer_login',
            'params'   => ['error' => $error]
        ]);
    }

    public function registerAction()
    {
        $error = false;
        $again = false;
        if (isset($_POST['customer'])) {
            if (!ctype_space($_POST['customer']['name']) && $_POST['customer']['password'] != '' && $this->_registerCustomer()) {
                $this->_loginCustomer();
                $this->_redirect('product_list');
            }
            else {
                $error = true;
                $again = true;
            }
        } else {
            $error = false;
            $again = true;
        }

        return $this->_di->get('View', [
            'template' => 'customer_register',
            'params'   => ['error' => $error]
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

    private function _loginCustomer()
    {
        $customer = new Customer($_POST['customer']);

//        $customer = $this->_di->get('Customer', ['data' => $_POST['customer']]);
        $customers = $this->_di->get('CustomerCollection');

        $id = $customers->loginAttempt($customer);
        $session = new Session();
        $session->login($id);

        return $session->isLoggedIn();
    }
}
