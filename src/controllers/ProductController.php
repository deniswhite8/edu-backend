<?php
require_once __DIR__ . '/../models/ProductCollection.php';
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
        require_once __DIR__ . '/../views/product_list.phtml';
    }
}