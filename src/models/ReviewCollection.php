<?php
/**
 * Created by PhpStorm.
 * User: denis
 * Date: 01.11.13
 * Time: 18:47
 */

require_once __DIR__ . '/Collection.php';
require_once __DIR__ . '/Review.php';

class ReviewCollection extends Collection
{

    public $product = null;

    public function getAverageRating()
    {
        $avg = '';
        if ($this->product)
            $avg = $this->_resource->avgWithWhereEqual('rating', 'product_id', $this->product->getId());
        else
            $avg = $this->_resource->avg('rating');

        return floatval(reset($avg[0]));
    }

    public function getReviewsOfProduct($product)
    {
        $ret = new ReviewCollection($this->_resource);
        $ret->product = $product;
        return $ret;
    }


    public function getReviews()
    {
        if ($this->product)
            return $this->toReviewsArray($this->_resource->whereEqual('product_id', $this->product->getId()));
        else
            return $this->toReviewsArray($this->_resource->fetch());
    }

    private function toReviewsArray($array)
    {
        return array_map(
            function ($data) {
                return new Review($data);
            },
            $array
        );
    }

    public function getIterator()
    {
        return new ArrayIterator($this->getReviews());
    }
}