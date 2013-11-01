<?php

require_once __DIR__ . '/../src/Product.php';

class ProductTest extends PHPUnit_Framework_TestCase
{
    public function testSkuEquals1()
    {
        $product = new Product(['sku' => '12345']);
        $this->assertEquals('12345', $product->getSku());
    }

    public function testSkuEquals2()
    {
        $product = new Product(['sku' => '567890']);
        $this->assertEquals('567890', $product->getSku());
    }

    public function testNameEquals1()
    {
        $product = new Product(['name' => 'Nokio']);
        $this->assertEquals('Nokio', $product->getName());
    }

    public function testNameEquals2()
    {
        $product = new Product(['name' => 'Motyorobla']);
        $this->assertEquals('Motyorobla', $product->getName());
    }

    public function testImageEquals1()
    {
        $product = new Product(['image' => 'http://url.ru/img.jpg']);
        $this->assertEquals('http://url.ru/img.jpg', $product->getImage());
    }

    public function testImageEquals2()
    {
        $product = new Product(['image' => 'http://url.ru/img2.jpg']);
        $this->assertEquals('http://url.ru/img2.jpg', $product->getImage());
    }


    public function testPriceEquals1()
    {
        $product = new Product(['price' => 123.5]);
        $this->assertEquals(123.5, $product->getPrice());
    }

    public function testPriceEquals2()
    {
        $product = new Product(['price' => 42]);
        $this->assertEquals(42, $product->getPrice());
    }

    public function testSpecialPriceIsTrue()
    {
        $product = new Product(['special_price' => 123.5]);
        $this->assertEquals(true, $product->isSpecialPriceApplied());
    }

    public function testSpecialPriceIsFalse()
    {
        $product = new Product([]);
        $this->assertEquals(false, $product->isSpecialPriceApplied());
    }

    public function testSpecialPriceEquals1()
    {
        $product = new Product(['special_price' => 123.5]);
        $this->assertEquals(123.5, $product->getSpecialPrice());
    }

    public function testSpecialPriceEquals2()
    {
        $product = new Product(['special_price' => 42]);
        $this->assertEquals(42, $product->getSpecialPrice());
    }
}
