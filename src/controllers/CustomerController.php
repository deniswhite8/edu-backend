<?php
namespace App\Controller;

use App\Model\CustomerCollection;
use App\Model\Resource\DBCollection;
use App\Model\Resource\DBEntity;
use App\Model\Customer;
use App\Model\Resource\Table\Customer as CustomerTable;
use App\Model\Session;

class CustomerController
{

    public function loginAction()
    {
        if (isset($_POST['customer'])) {
            if ($this->_loginCustomer()) $this->_goBack();
            else {
                $error = true;
                $view = 'customer_login';
                require_once __DIR__ . '/../views/layout/main.phtml';
            }
        } else {
            $error = false;
            $view = 'customer_login';
            require_once __DIR__ . '/../views/layout/main.phtml';
        }
    }

    public function registerAction()
    {
        if (isset($_POST['customer'])) {
            $this->_registerCustomer();
        } else {
            $view = 'customer_register';
            require_once __DIR__ . '/../views/layout/main.phtml';
        }
    }

    public function logoutAction()
    {
        $session = new Session();
        $session->logout();
        $this->_goBack();
    }

    private function _registerCustomer()
    {
        $connection = new \PDO('mysql:host=localhost;dbname=student', 'root', '123');
        $resource = new DBEntity($connection, new CustomerTable);
        $customer = new Customer($_POST['customer']);
        $customer->save($resource);
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

        return $session->isLogged();
    }

    private function _goBack()
    {
        echo '<script>location.href="/"</script>';
    }
}
