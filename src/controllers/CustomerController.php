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
            if ($this->_loginCustomer()) $this->_goBack();
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
                $this->_goBack();
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
        $this->_goBack();
    }

    private function _registerCustomer()
    {
        $resource = $this->_di->get('ResourceEntity', ['table' => new \App\Model\Resource\Table\Customer()]);
//        $customer = $this->_di->get('Customer', ['data' => $_POST['customer'], 'resource' => $resource]);
        $customer = new Customer($_POST['customer'], $resource);


        try {
            $customer->save();
        } catch (\Exception $ex) {
            return false;
        }
        return true;
    }

    private function _loginCustomer()
    {
        $connection = new \PDO('mysql:host=localhost;dbname=student', 'root', '123');
        $resource = new DBCollection($connection, new CustomerTable);
        $customer = new Customer($_POST['customer']);
        $customers = new CustomerCollection($resource, new CustomerTable);

        $id = $customers->loginAttempt($customer);
        $session = new Session();
        $session->login($id);

        return $session->isLoggedIn();
    }

    private function _goBack()
    {
        echo '<script>location.href="/"</script>';
    }
}
