<?php
/**
 * Created by PhpStorm.
 * User: denis
 * Date: 01.11.13
 * Time: 18:47
 */

require_once __DIR__ . '/Collection.php';

class ReviewCollection extends Collection
{
    public function getAverageRating()
    {
        $allReviews = $this->_getAllData();
        $size = count($allReviews);

        if ($size == 0) throw new UnderflowException('Impossible to calculate the average rating of the empty collection reviews');

        $ratings = array_map(function (Review $review) {
            return $review->getRating();
        }, $allReviews);

        return array_sum($ratings) / $size;
    }

    public function getReviewOfProduct($product)
    {
        $allReviews = $this->_getAllData();
        $newData = array_filter($allReviews, function (Review $review) use($product) {
            return $review->belongsToProduct($product);
        });
        return new ReviewCollection(array_values($newData));
    }


    public function getReviews()
    {
        return $this->_getData();
    }
}