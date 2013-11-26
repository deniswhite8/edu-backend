<?php
/**
 * Created by PhpStorm.
 * User: denis
 * Date: 01.11.13
 * Time: 19:51
 */

require_once __DIR__ . '/../src/models/ReviewCollection.php';

class __ReviewCollection extends PHPUnit_Framework_TestCase {
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

    public function testForeachWithLimitAndOffsetPositive()
    {
        $inputArray = [new Review(['name' => 'a']), new Review(['name' => 'b']), new Review(['name' => 'c']),
            new Review(['name' => 'd'])];
        $reviewCollection = new ReviewCollection($inputArray);

        $reviewCollection->limit(2);
        $reviewCollection->offset(1);

        $arr = array();
        foreach($reviewCollection as $val) {
            $arr[] = $val;
        }

        $this->assertEquals([new Review(['name' => 'b']), new Review(['name' => 'c'])], $arr);
    }

    public function testForeachWithLimitAndOffsetNegative()
    {
        $inputArray = [new Review(['name' => 'a']), new Review(['name' => 'b']), new Review(['name' => 'c']),
            new Review(['name' => 'd'])];
        $reviewCollection = new ReviewCollection($inputArray);

        $reviewCollection->limit(100);
        $reviewCollection->offset(1);

        $arr = array();
        foreach($reviewCollection as $val) {
            $arr[] = $val;
        }

        $this->assertEquals([new Review(['name' => 'b']), new Review(['name' => 'c']), new Review(['name' => 'd'])], $arr);

        //******//

        $reviewCollection->limit(2);
        $reviewCollection->offset(100);

        $arr = array();
        foreach($reviewCollection as $val) {
            $arr[] = $val;
        }

        $this->assertEquals([], $arr);
    }

    public function testGetAverageRating()
    {
        $inputArray = [new Review(['rating' => 1]), new Review(['rating' => 3]), new Review(['rating' => 5])];
        $reviewCollection = new ReviewCollection($inputArray);

        $this->assertEquals(3, $reviewCollection->getAverageRating());

        //******//

        $reviewCollection = new ReviewCollection([]);
        $excp = null;
        try {
            $reviewCollection->getAverageRating();
        } catch (Exception $ex) {
            $excp = $ex;
        }
        $this->assertEquals(new UnderflowException('Impossible to calculate the average rating of the empty collection reviews'), $excp);
    }

    public function testGetReviewsWithOffsetAndLimit()
    {
        $inputArray = [new Review(['rating' => 1]), new Review(['rating' => 3]), new Review(['rating' => 5]), new Review(['rating' => 3])];
        $reviewCollection = new ReviewCollection($inputArray);
        $reviewCollection->offset(1);
        $reviewCollection->limit(2);
        $this->assertEquals([new Review(['rating' => 3]), new Review(['rating' => 5])], $reviewCollection->getReviews());
    }

    public function testGetAverageWithOffsetAndLimit()
    {
        $inputArray = [new Review(['rating' => 1]), new Review(['rating' => 3]), new Review(['rating' => 5]), new Review(['rating' => 3])];
        $reviewCollection = new ReviewCollection($inputArray);
        $reviewCollection->offset(1);
        $reviewCollection->limit(2);
        $this->assertEquals(3, $reviewCollection->getAverageRating());
    }

    public function testGetReviewOfProductWithOffsetAndLimit()
    {
        $product = new Product(['sku' => 321]);
        $arr = [new Review(['product' => $product, 'name' => 'a']), new Review(['product' => $product, 'name' => 'b']),
            new Review(['product' => $product, 'name' => 'c'])];
        $reviewCollection = new ReviewCollection(array_merge($arr));
        $reviewCollection->offset(1);
        $reviewCollection->limit(1);

        $this->assertEquals(new ReviewCollection($arr), $reviewCollection->getReviewsOfProduct($product));
    }

    public function testGetReviewOfProduct()
    {
        $product = new Product(['sku' => 321]);
        $arr1 = [new Review(['product' => $product, 'name' => 'a']), new Review(['product' => $product, 'name' => 'b'])];
        $arr2 = [new Review(['product' => new Product([]), 'name' => 'c']), new Review(['product' => new Product([]), 'name' => 'd'])];

        $reviewCollection = new ReviewCollection(array_merge($arr2, $arr1));
        $this->assertEquals(new ReviewCollection($arr1), $reviewCollection->getReviewsOfProduct($product));
    }

    public function testSort()
    {
        $arr = [new Review(['name' => 'good', 'rating' => 4]), new Review(['name' => 'bad', 'rating' => 2]),
            new Review(['name' => 'shit', 'rating' => 1]), new Review(['name' => 'very good!', 'rating' => 5])];
        $reviewCollection = new ReviewCollection($arr);

        $reviewCollection->sort('name');
        $this->assertEquals([new Review(['name' => 'bad', 'rating' => 2]), new Review(['name' => 'good', 'rating' => 4]),
            new Review(['name' => 'shit', 'rating' => 1]), new Review(['name' => 'very good!', 'rating' => 5])],
            $reviewCollection->getReviews());

        //******//


        $reviewCollection->sort('rating');
        $this->assertEquals([new Review(['name' => 'shit', 'rating' => 1]), new Review(['name' => 'bad', 'rating' => 2]),
                new Review(['name' => 'good', 'rating' => 4]), new Review(['name' => 'very good!', 'rating' => 5])],
            $reviewCollection->getReviews());

    }
}
