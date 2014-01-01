<?php
namespace App\Controller;

class AdminController extends ActionController
{
    public function productsAction()
    {
        $orderBy = isset($_GET['order']) ? $_GET['order'] : 'sku';
        $reverse = isset($_GET['reverse']);
        $searchBy = isset($_GET['searchBy']) ? $_GET['searchBy'] : '';
        $searchStr = isset($_GET['searchStr']) ? $_GET['searchStr'] : '';

        $productCollection = $this->_di->get('ProductCollection');
        $productCollection->sortBy($orderBy, $reverse);
        if (isset($_GET['searchBy']) && isset($_GET['searchStr']) && $_GET['searchBy'] && $_GET['searchStr'])
            $productCollection->search($_GET['searchBy'], $_GET['searchStr']);

        $modelView = $this->_di->get('View', [
            'template' => 'admin_products',
            'params' => [
                'product_collection' => $productCollection,
                'current' => 'products',
                'reverse' => $reverse,
                'orderBy' => $orderBy,
                'searchBy' => $searchBy,
                'searchStr' => $searchStr
            ]
        ]);
        $modelView->setLayout('admin');

        return $modelView;
    }


    public function editProductAction()
    {
        if ($this->_isPost()) {
            $product = $this->_di->get('Product');
            $product->setData($_POST['product']);

            move_uploaded_file($_FILES['image']['tmp_name'], __DIR__ . '/../../public/product_images/' . $product->getId());

            $product->setField('image', './product_images/' . $product->getId());
            $product->save();

            $this->_redirect('admin_products');
        } else {
            $product = $this->_di->get('Product');
            $product->load($_GET['id']);

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