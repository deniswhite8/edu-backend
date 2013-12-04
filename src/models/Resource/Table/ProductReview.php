<?php
/**
 * Created by PhpStorm.
 * User: denis
 * Date: 04.12.13
 * Time: 18:30
 */

namespace App\Model\Resource\Table;


class ProductReview implements ITable {
    public function getName()
    {
        return 'reviews';
    }

    public function getPrimaryKey()
    {
        return 'review_id';
    }
}
