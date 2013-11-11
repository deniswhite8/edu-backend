<?php
require_once __DIR__ . '/../models/ProductCollection.php';
require_once __DIR__ . '/../models/ReviewCollection.php';
require_once __DIR__ . '/../models/Review.php';
require_once __DIR__ . '/../models/Product.php';

class ProductController
{
    public function viewAction()
    {
        $product = new ProductCollection([
            new Product([
                'image' => 'http://www.saleable.ru/696-2971-large/kozhanyj-chexol-dlja-nokia-e72-new-.jpg',
                'name' => 'Nokla',
                'sku' => '19403',
                'price' => 100,
                'special_price' => 99
            ]),
            new Product([
                'image' => 'http://www.stariy.com/files/2009/04/vertu-ascent-ti-fake-replica-copy_1.jpg',
                'name' => 'Verchu',
                'sku' => '65843',
                'price' => 19,
                'special_price' => 9
            ])
        ]);

        $_page = __DIR__ . '/../views/product_list.phtml';
        include(__DIR__ . '/../views/main.phtml');
    }

    public function itemAction()
    {
        $product = new Product([
                'image' => 'http://www.saleable.ru/696-2971-large/kozhanyj-chexol-dlja-nokia-e72-new-.jpg',
                'name' => 'Nokla',
                'sku' => '19403',
                'price' => 100,
                'special_price' => 99
            ]);

        $reviews = new ReviewCollection([
            new Review([
                'name' => 'Petya',
                'text' => 'good phone!',
                'email' => 'petya@gmail.com',
                'rating' => 5,
                'product' => $product
            ]),
            new Review([
                'name' => 'Vasya',
                'text' => 'norm',
                'email' => 'vasilii@gmail.com',
                'rating' => 4,
                'product' => $product
            ]),
            new Review([
                'name' => 'fedya',
                'text' => 'very bad!!!1',
                'email' => 'fff@gmail.com',
                'rating' => 1,
                'product' => $product
            ])
        ]);

        $_page = __DIR__ . '/../views/product_page.phtml';
        include(__DIR__ . '/../views/main.phtml');
    }
}