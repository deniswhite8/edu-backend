<?php
namespace App\Model;

class ProductReview extends Entity
{
    public function getName()
    {
        return $this->getData('name');
    }

    public function getEmail()
    {
        return $this->getData('email');
    }

    public function getText()
    {
        return $this->getData('text');
    }

    public function getRating()
    {
        return $this->getData('rating');
    }

    public function belongsToProduct(Product $product)
    {
        return $product == $this->getData('product');
    }
}
