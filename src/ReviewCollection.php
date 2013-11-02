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
        $size = $this->getSize();
        $sum = 0;

        foreach ($this as $review) {
            $sum += $review->getRating();
        }

        return $sum / $size;
    }

    public function getReviewOfProduct($product)
    {
        $arr = array();
        foreach ($this as $review) {
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