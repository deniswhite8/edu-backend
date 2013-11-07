<?php

require_once __DIR__ . '/../src/models/Product.php';

class ProductTest extends PHPUnit_Framework_TestCase
{
    public function testSkuEquals()
    {
        $product = new Product(['sku' => '12345']);
        $this->assertEquals('12345', $product->getSku());

        $product = new Product(['sku' => '567890']);
        $this->assertEquals('567890', $product->getSku());
    }

    public function testNameEquals()
    {
        $product = new Product(['name' => 'Nokio']);
        $this->assertEquals('Nokio', $product->getName());

        $product = new Product(['name' => 'Motyorobla']);
        $this->assertEquals('Motyorobla', $product->getName());
    }

    public function testImageEquals()
    {
        $product = new Product(['image' => 'http://url.ru/img.jpg']);
        $this->assertEquals('http://url.ru/img.jpg', $product->getImage());

        $product = new Product(['image' => 'http://url.ru/img2.jpg']);
        $this->assertEquals('http://url.ru/img2.jpg', $product->getImage());
    }


    public function testPriceEquals()
    {
        $product = new Product(['price' => 123.5]);
        $this->assertEquals(123.5, $product->getPrice());

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

    public function testSpecialPriceEquals()
    {
        $product = new Product(['special_price' => 123.5]);
        $this->assertEquals(123.5, $product->getSpecialPrice());

        $product = new Product(['special_price' => 42]);
        $this->assertEquals(42, $product->getSpecialPrice());
    }
}
