<?php
/**
 * Created by PhpStorm.
 * User: denis
 * Date: 01.11.13
 * Time: 19:04
 */

require_once __DIR__ . '/../src/models/Review.php';
require_once __DIR__ . '/../src/models/Product.php';

class ReviewTest extends PHPUnit_Framework_TestCase
{
    public function testGetNameEquals()
    {
        $review = new Review(['name' => 'good']);
        $this->assertEquals('good', $review->getName());
    }

    public function testGetEmailEquals()
    {
        $review = new Review(['email' => 'mail@gmail.com']);
        $this->assertEquals('mail@gmail.com', $review->getEmail());
    }

    public function testGetTextEquals()
    {
        $review = new Review(['text' => "very good, i'm happy"]);
        $this->assertEquals("very good, i'm happy", $review->getText());
    }

    public function testGetRatingEquals()
    {
        $review = new Review(['rating' => 5]);
        $this->assertEquals(5, $review->getRating());
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Rating must be an integer number and is in the range from 1 to 5
     */
    public function testSetIncorrectRating()
    {
        new Review(['rating' => 9]);
    }

//    public function testGetProduct()
//    {
//        $product = new Product(['sku' => 12345]);
//        $review = new Review(['product' => $product]);
//
//        $this->assertEquals($product, $review->getProduct());
//    }
//
//    public function testBelongsToProductPositive()
//    {
//        $product = new Product(['sku' => 12345]);
//        $review = new Review(['product' => $product]);
//        $this->assertEquals(true, $review->belongsToProduct($product));
//    }
//
//    public function testBelongsToProductNegative()
//    {
//        $product = new Product(['sku' => 12345]);
//        $review = new Review([]);
//        $this->assertEquals(false, $review->belongsToProduct($product));
//    }
}