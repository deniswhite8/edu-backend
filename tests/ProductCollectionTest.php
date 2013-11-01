<?php

require_once __DIR__ . '/../src/Product.php';
require_once __DIR__ . '/../src/ProductCollection.php';

class ProductCollectionTest extends PHPUnit_Framework_TestCase {
    public function testGetProductsEquals1() {
        $products = new ProductCollection([new Product(['sku' => 'fuu']), new Product(['sku' => 'bar'])]);
        $this->assertEquals([new Product(['sku' => 'fuu']), new Product(['sku' => 'bar'])], $products->getProducts());
    }

    public function testGetSizeEquals1() {
        $products = new ProductCollection([new Product([]), new Product([])]);
        $this->assertEquals(2, $products->getSize());
    }

    public function testGetSizeEquals2() {
        $products = new ProductCollection([new Product([])]);
        $this->assertEquals(1, $products->getSize());
    }

    public function testGetSizeWithLimitEquals1() {
        $products = new ProductCollection([new Product(['sku' => 'fuu']), new Product(['sku' => 'bar']), new Product(['sku' => 'baz'])]);
        $products->limit(1);
        $this->assertEquals(1, $products->getSize());
    }

    public function testGetProductsWithLimitEquals1() {
        $products = new ProductCollection([new Product(['sku' => 'fuu']), new Product(['sku' => 'bar']), new Product(['sku' => 'baz'])]);
        $products->limit(1);
        $this->assertEquals([new Product(['sku' => 'fuu'])], $products->getProducts());
    }

    public function testGetSizeWithLimitEquals2() {
        $products = new ProductCollection([new Product(['sku' => 'fuu']), new Product(['sku' => 'bar']), new Product(['sku' => 'baz'])]);
        $products->limit(2);
        $this->assertEquals(2, $products->getSize());
    }

    public function testGetProductsWithLimitEquals2() {
        $products = new ProductCollection([new Product(['sku' => 'fuu']), new Product(['sku' => 'bar']), new Product(['sku' => 'baz'])]);
        $products->limit(2);
        $this->assertEquals([new Product(['sku' => 'fuu']), new Product(['sku' => 'bar'])], $products->getProducts());
    }

    public function testGetProductsWithOffsetEquals1() {
        $products = new ProductCollection([new Product(['sku' => 'fuu']), new Product(['sku' => 'bar']), new Product(['sku' => 'baz'])]);
        $products->offset(0);
        $this->assertEquals([new Product(['sku' => 'fuu']), new Product(['sku' => 'bar']), new Product(['sku' => 'baz'])], $products->getProducts());
    }

    public function testGetProductsWithOffsetEquals2() {
        $products = new ProductCollection([new Product(['sku' => 'fuu']), new Product(['sku' => 'bar']), new Product(['sku' => 'baz'])]);
        $products->offset(1);
        $this->assertEquals([new Product(['sku' => 'bar']), new Product(['sku' => 'baz'])], $products->getProducts());
    }

    public function testGetProductsWithOffsetEquals3() {
        $products = new ProductCollection([new Product(['sku' => 'fuu']), new Product(['sku' => 'bar']), new Product(['sku' => 'baz'])]);
        $products->offset(2);
        $this->assertEquals([new Product(['sku' => 'baz'])], $products->getProducts());
    }

    public function testGetSizeWithOffsetEquals1() {
        $products = new ProductCollection([new Product([])]);
        $products->limit(100);
        $this->assertEquals(1, $products->getSize());
    }

    public function testGetSizeWithOffsetAndLimitEquals1() {
        $products = new ProductCollection([new Product([]), new Product([])]);
        $products->offset(2);
        $products->limit(1);
        $this->assertEquals(0, $products->getSize());
    }

    public function testGetProductsWithOffsetAndLimitEquals1() {
        $products = new ProductCollection([new Product(['sku' => 1]), new Product(['sku' => 2]), new Product(['sku' => 3])]);
        $products->offset(1);
        $products->limit(1);
        $this->assertEquals([new Product(['sku' => 2])], $products->getProducts());
    }

    public function testGetSizeWithOffsetAndLimitEquals2() {
        $products = new ProductCollection([new Product(['sku' => 1]), new Product(['sku' => 2]), new Product(['sku' => 3])]);
        $products->offset(1);
        $products->limit(1);
        $this->assertEquals(1, $products->getSize());
    }
}
