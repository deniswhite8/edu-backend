<?php
namespace App\Controller;

use App\Model\Product;

class ProductController extends ActionController
{

    public function listAction()
    {
        $resource = $this->_di->get('ResourceCollection', ['table' => new \App\Model\Resource\Table\Product()]);
        $paginator = $this->_di->get('Paginator', ['collection' => $resource]);
        $paginator
            ->setItemCountPerPage(2)
            ->setCurrentPageNumber(isset($_GET['p']) ? $_GET['p'] : 1);
        $pages = $paginator->getPages();

        $product = $this->_di->get('Product');
        $products = $this->_di->get('ProductCollection', ['resource' => $resource, 'productPrototype' => $product]);

        return $this->_di->get('View', [
            'template' => 'product_list',
            'params'   => ['products' => $products, 'pages' => $pages]
        ]);

    }

    public function viewAction()
    {
        $this->_di->get('Session')->generateToken();


        $product = $this->_di->get('Product');
        $product->load($_GET['id']);

        $reviewsResource = $this->_di->get('ResourceCollection', ['table' => new \App\Model\Resource\Table\ProductReview()]);
        $reviews = $this->_di->get('ProductReviewCollection', ['resource' => $reviewsResource]);
        $reviews->filterByProduct($product);

        $paginator = $this->_di->get('Paginator', ['collection' => $reviewsResource]);
        $paginator->setItemCountPerPage(2)
                  ->setCurrentPageNumber(isset($_GET['p']) ? $_GET['p'] : 1);
        $pages = $paginator->getPages();

        return $this->_di->get('View', [
            'template' => 'product_view',
            'params'   => ['product' => $product, 'pages' => $pages, 'reviews' => $reviews]
        ]);
    }
}
