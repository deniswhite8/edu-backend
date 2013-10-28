<?php

require_once __DIR__ . '/../src/Product.php';
require_once __DIR__ . '/../src/ProductCollection.php';

// getProducts
$products = new ProductCollection([new Product(['sku' => 'fuu']), new Product(['sku' => 'bar'])]);
assert($products->getProducts() == [new Product(['sku' => 'fuu']), new Product(['sku' => 'bar'])], 'error');


// getSize
$products = new ProductCollection([new Product([]), new Product([])]);
assert($products->getSize() == 2);
$products = new ProductCollection([new Product([])]);
assert($products->getSize() == 1);


// limit
$products = new ProductCollection([new Product(['sku' => 'fuu']), new Product(['sku' => 'bar']), new Product(['sku' => 'baz'])]);
$products->limit(1);
assert($products->getSize() == 1);
assert($products->getProducts() == [new Product(['sku' => 'fuu'])], 'error');

$products = new ProductCollection([new Product(['sku' => 'fuu']), new Product(['sku' => 'bar']), new Product(['sku' => 'baz'])]);
$products->limit(2);
assert($products->getSize() == 2);
assert($products->getProducts() == [new Product(['sku' => 'fuu']), new Product(['sku' => 'bar'])], 'error');


// offset
$products = new ProductCollection([new Product(['sku' => 'fuu']), new Product(['sku' => 'bar']), new Product(['sku' => 'baz'])]);
$products->offset(0);
assert($products->getProducts() == [new Product(['sku' => 'fuu']), new Product(['sku' => 'bar']), new Product(['sku' => 'baz'])], 'error');

$products = new ProductCollection([new Product(['sku' => 'fuu']), new Product(['sku' => 'bar']), new Product(['sku' => 'baz'])]);
$products->offset(1);
assert($products->getProducts() == [new Product(['sku' => 'bar']), new Product(['sku' => 'baz'])], 'error');

$products = new ProductCollection([new Product(['sku' => 'fuu']), new Product(['sku' => 'bar']), new Product(['sku' => 'baz'])]);
$products->offset(2);
assert($products->getProducts() == [new Product(['sku' => 'baz'])], 'error');