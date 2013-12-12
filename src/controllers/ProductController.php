<?php
namespace App\Controller;

use App\Model\Resource\DBCollection;
use App\Model\Resource\DBEntity;
use App\Model\ProductCollection;
use App\Model\ProductReviewCollection;
use App\Model\Product;
use App\Model\Resource\Table\Product as ProductTable;
use App\Model\Resource\Table\ProductReview as ProductReviewTable;
use App\Model\Resource\Paginator as PaginatorAdapter;
use Zend\Paginator\Paginator as Zend_Paginator;
use Zend\View\ViewEvent;


class ProductController
{
    private $_di;

    public function __construct(\Zend\Di\Di $di)
    {
        $this->_di = $di;
    }

    public function listAction()
    {
        $resource = $this->_di->get('ResourceCollection', ['table' => new ProductTable()]);
        $paginator = $this->_di->get('Paginator', ['collection' => $resource]);
        $products = $this->_di->get('ProductCollection', ['resource' => $resource]);

        $paginator->setItemCountPerPage(2);
        $paginator->setCurrentPageNumber(isset($_GET['p']) ? $_GET['p'] : 1);

        $pages = $paginator->getPages();

        return $this->_di->get('View', [
            'template' => 'product_list',
            'params' => ['products' => $products, ]
        ]);

//        $view = 'product_list';
//        require_once __DIR__ . '/../views/layout/base.phtml';
    }

    public function viewAction()
    {
        $product = new Product([]);

        $connection = new \PDO('mysql:host=localhost;dbname=student', 'root', '123');
        $productResource = new DBEntity($connection, new ProductTable);
        $product->load($productResource, $_GET['id']);

        $reviewResource = new DBCollection($connection, new ProductReviewTable);
        $reviews = new ProductReviewCollection($reviewResource);
        $reviews->filterByProduct($product);

        $paginatorAdapter = new PaginatorAdapter($reviewResource);
        $paginator = new Zend_Paginator($paginatorAdapter);
        $paginator->setItemCountPerPage(2);
        $paginator->setCurrentPageNumber(isset($_GET['p']) ? $_GET['p'] : 1);

        $pages = $paginator->getPages();

        $view = 'product_view';
        require_once __DIR__ . '/../views/layout/base.phtml';
    }
}
