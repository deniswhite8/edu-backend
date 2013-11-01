<?php
/**
 * Created by PhpStorm.
 * User: denis
 * Date: 01.11.13
 * Time: 19:51
 */

require_once __DIR__ . '/../src/ReviewCollection.php';

class ReviewCollectionTest extends PHPUnit_Framework_TestCase {
    public function testForeach()
    {
        $inputArray = [new Review(['name' => 'a']), new Review(['name' => 'b']), new Review(['name' => 'c'])];
        $reviewCollection = new ReviewCollection($inputArray);

        $arr = array();
        foreach($reviewCollection as $val) {
            $arr[] = $val;
        }

        $this->assertEquals($inputArray, $arr);
    }

    public function testGetAverageRating()
    {
        $inputArray = [new Review(['rating' => 1]), new Review(['rating' => 3]), new Review(['rating' => 5])];
        $reviewCollection = new ReviewCollection($inputArray);

        $this->assertEquals(3, $reviewCollection->getAverageRating());
    }

    public function testGetReviewOfProduct()
    {
        $product = new Product([]);
        $arr1 = [new Review(['product' => $product, 'name' => 'a']), new Review(['product' => $product, 'name' => 'b'])];
        $arr2 = [new Review(['product' => new Product([]), 'name' => 'c']), new Review(['product' => new Product([]), 'name' => 'd'])];

        $reviewCollection = new ReviewCollection(array_merge($arr1, $arr2));
        $this->assertEquals($arr1, $reviewCollection->getReviewOfProduct($product));
    }
}