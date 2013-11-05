<?php
/**
 * Created by PhpStorm.
 * User: denis
 * Date: 01.11.13
 * Time: 16:47
 */

require_once __DIR__ . '/Сontainer.php';

class Review extends Сontainer
{
    public function __construct(array $data)
    {
        if (isset($data['rating'])) {
            $rating = $data['rating'];
            if (!(is_int($rating) && $rating >= 1 && $rating <= 5)) {
                throw new InvalidArgumentException('Rating must be an integer number and is in the range from 1 to 5');
            }
        }
        parent::__construct($data);
    }

    public function getName()
    {
        return $this->getField('name');
    }

    public function getEmail()
    {
        return $this->getField('email');
    }

    public function getText()
    {
        return $this->getField('text');
    }

    public function getRating()
    {
        return $this->getField('rating');
    }

    public function belongsToProduct($product)
    {
        return $this->getProduct() == $product;
    }

    public function getProduct()
    {
        return $this->getField('product');
    }
}