<?php
namespace App\Controller;

use App\Model\Admin;

class AdminController extends ActionController
{
    public function loginAction()
    {
        $error = false;
        if (isset($_POST['admin'])) {
            if ($this->_loginAdmin()) $this->_redirect('admin_products');
            else {
                $error = true;
            }
        } else {
            $error = false;
        }


        $modelView = $this->_di->get('View', [
            'template' => 'admin_login',
            'params' => [
                'current' => 'login',
                'error' => $error
            ]
        ]);
        $modelView->setLayout('admin');

        return $modelView;
    }

    public function logoutAction()
    {
        $session = $this->_di->get('Session');
        $session->setAdminMode();

        $session->logout();
        $this->_redirect('admin_login');
    }

    private function _loginAdmin()
    {
        $admin = $this->_di->get('Admin', ['idata' => $_POST['admin']]);
        $admins = $this->_di->get('AdminCollection');

        $id = $admins->loginAttempt($admin);

        $session = $this->_di->get('Session');
        $session->setAdminMode();
        $session->login($id);

        return $session->isLoggedIn();
    }

    public function _mustLogin()
    {
        $session = $this->_di->get('Session');
        $session->setAdminMode();

        if (!$session->isLoggedIn())
            $this->_redirect('admin_login');
    }

    public function productsAction()
    {
        $this->_mustLogin();


        $resource = $this->_di->get('ResourceCollection', ['table' => new \App\Model\Resource\Table\Product()]);
        $paginator = $this->_di->get('Paginator', ['collection' => $resource]);


        $orderBy = isset($_GET['order']) ? $_GET['order'] : 'sku';
        $reverse = isset($_GET['reverse']);
        $searchBy = isset($_GET['searchBy']) ? $_GET['searchBy'] : '';
        $searchStr = isset($_GET['searchStr']) ? $_GET['searchStr'] : '';

        $product = $this->_di->get('Product');
        $productCollection = $this->_di->get('ProductCollection', ['resource' => $resource, 'productPrototype' => $product]);

        $productCollection->sortBy($orderBy, $reverse);
        if (isset($_GET['searchBy']) && isset($_GET['searchStr']) && $_GET['searchBy'] && $_GET['searchStr'])
            $productCollection->search($_GET['searchBy'], $_GET['searchStr']);


        $paginator
            ->setItemCountPerPage(2)
            ->setCurrentPageNumber(isset($_GET['p']) ? $_GET['p'] : 1);
        $pages = $paginator->getPages();


        $modelView = $this->_di->get('View', [
            'template' => 'admin_products',
            'params' => [
                'product_collection' => $productCollection,
                'current' => 'products',
                'reverse' => $reverse,
                'orderBy' => $orderBy,
                'searchBy' => $searchBy,
                'searchStr' => $searchStr,
                'pages' => $pages
            ]
        ]);
        $modelView->setLayout('admin');

        return $modelView;
    }


    public function editProductAction()
    {
        $this->_mustLogin();

        $session = $this->_di->get('Session');

        if ($this->_isPost() && $session->validateToken($_POST['token'])) {
            $product = $this->_di->get('Product');
            $product->setData($_POST['product']);

            if ($_POST['action'] == 'Update' || $_POST['action'] == 'Create') {
                $product->save();
                $product->setField('image', './product_images/' . $product->getId());
                $product->save();
                move_uploaded_file($_FILES['image']['tmp_name'], __DIR__ . '/../../public/product_images/' . $product->getId());
            } else if ($_POST['action'] == 'Delete') {
                unlink(__DIR__ . '/../../public/product_images/' . $product->getId());
                $product->delete();
            }

            $this->_redirect('admin_products');
        } else {
            $product = $this->_di->get('Product');
            if (isset($_GET['id'])) $product->load($_GET['id']);

            $session->generateToken();

            $modelView = $this->_di->get('View', [
                'template' => 'admin_editProduct',
                'params' => [
                    'product' => $product,
                    'current' => 'products',
                    'new' => !$product->getId()
                ]
            ]);
            $modelView->setLayout('admin');

            return $modelView;
        }
    }
}