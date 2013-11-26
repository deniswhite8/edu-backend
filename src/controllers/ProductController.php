<?php
require_once __DIR__ . '/../models/ProductCollection.php';
require_once __DIR__ . '/../models/ReviewCollection.php';
require_once __DIR__ . '/../models/Resource/DBCollection.php';
require_once __DIR__ . '/../models/Resource/DBEntity.php';
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/Resource/DBConfig.php';

class ProductController
{
    public function listAction()
    {
        $dbconf = $GLOBALS['dbconf'];
        $connection = $dbconf->getConnection();
        $resource = new DBCollection($connection, 'products');
        $products = new ProductCollection($resource);

        $_page = __DIR__ . '/../views/product_list.phtml';
        include(__DIR__ . '/../views/main.phtml');
    }

    public function viewAction()
    {
        $product = new Product([]);

        $dbconf = $GLOBALS['dbconf'];
        $connection = $dbconf->getConnection();

        $tableName = 'products';
        $primaryKey = $dbconf->getPrimaryKey($tableName);
        $resource = new DBEntity($connection, $tableName, $primaryKey);
        $product->load($resource, $_GET['id']);

        $reviewsRes = new DBCollection($connection, 'reviews');
        $allReviews = new ReviewCollection($reviewsRes);
        $reviews = $allReviews->getReviewsOfProduct($product);

        $_page = __DIR__ . '/../views/product_page.phtml';
        include(__DIR__ . '/../views/main.phtml');
    }
}
