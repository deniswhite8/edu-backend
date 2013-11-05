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
        $allReviews = $this->getReviews();
        $size = count($allReviews);
        $sum = 0;

        if ($size == 0) throw new UnderflowException('Impossible to calculate the average rating of the empty collection reviews');

        foreach ($allReviews as $review) {
            $sum += $review->getRating();
        }

        return $sum / $size;
    }

    public function getReviewOfProduct($product)
    {
        $arr = array();
        $allReviews = $this->getReviews();
        foreach ($allReviews as $review) {
            if ($review->belongsToProduct($product)) {
                $arr[] = $review;
            }
        }

        return $arr;
    }


    public function getReviews()
    {
        return $this->_getData();
    }
}