<?php

require_once __DIR__ . '/../src/Product.php';
require_once __DIR__ . '/../src/ProductCollection.php';

// getProducts
$products = new ProductCollection([new Product(['sku' => 'fuu']), new Product(['sku' => 'bar'])]);
if(assert($products->getProducts() == [new Product(['sku' => 'fuu']), new Product(['sku' => 'bar'])], 'error')) {
    echo '.';
}


// getSize
$products = new ProductCollection([new Product([]), new Product([])]);
if(assert($products->getSize() == 2)) {
    echo '.';
}
$products = new ProductCollection([new Product([])]);
if(assert($products->getSize() == 1)) {
    echo '.';
}


// limit
$products = new ProductCollection([new Product(['sku' => 'fuu']), new Product(['sku' => 'bar']), new Product(['sku' => 'baz'])]);
$products->limit(1);
if(assert($products->getSize() == 1)) {
    echo '.';
}
if(assert($products->getProducts() == [new Product(['sku' => 'fuu'])], 'error')) {
    echo '.';
}

$products = new ProductCollection([new Product(['sku' => 'fuu']), new Product(['sku' => 'bar']), new Product(['sku' => 'baz'])]);
$products->limit(2);
if(assert($products->getSize() == 2)) {
    echo '.';
}
if(assert($products->getProducts() == [new Product(['sku' => 'fuu']), new Product(['sku' => 'bar'])], 'error')) {
    echo '.';
}


// offset
$products = new ProductCollection([new Product(['sku' => 'fuu']), new Product(['sku' => 'bar']), new Product(['sku' => 'baz'])]);
$products->offset(0);
if(assert($products->getProducts() == [new Product(['sku' => 'fuu']), new Product(['sku' => 'bar']), new Product(['sku' => 'baz'])], 'error')) {
    echo '.';
}

$products = new ProductCollection([new Product(['sku' => 'fuu']), new Product(['sku' => 'bar']), new Product(['sku' => 'baz'])]);
$products->offset(1);
if(assert($products->getProducts() == [new Product(['sku' => 'bar']), new Product(['sku' => 'baz'])], 'error')) {
    echo '.';
}

$products = new ProductCollection([new Product(['sku' => 'fuu']), new Product(['sku' => 'bar']), new Product(['sku' => 'baz'])]);
$products->offset(2);
if(assert($products->getProducts() == [new Product(['sku' => 'baz'])], 'error')) {
    echo '.';
}

$products = new ProductCollection([new Product([])]);
$products->limit(100);
if(assert($products->getSize() == 1, 'error')) {
    echo '.';
}

$products = new ProductCollection([new Product([]), new Product([])]);
$products->offset(2);
$products->limit(1);
if(assert($products->getSize() == 0, 'error')) {
    echo '.';
}

$products = new ProductCollection([new Product(['sku' => 1]), new Product(['sku' => 2]), new Product(['sku' => 3])]);
$products->offset(1);
$products->limit(1);
if(assert($products->getProducts() == [new Product(['sku' => 2])], 'error')) {
    echo '.';
}
if(assert($products->getSize() == 1, 'error')) {
    echo '.';
}

echo "\n";