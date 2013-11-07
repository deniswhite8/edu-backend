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
                'sku' => '1234567890',
                'price' => 100,
                'special_price' => 99
            ])
        ]);
        require_once __DIR__ . '/../views/product_list.phtml';
    }
}