<?php
/**
 * Created by PhpStorm.
 * User: denis
 * Date: 01.11.13
 * Time: 16:47
 */

require_once __DIR__ . '/Сontainer.php';

class Review extends Сontainer {
    public function getName() {
        return $this->_getData('name');
    }

    public function getEmail() {
        return $this->_getData('email');
    }

    public function getText() {
        return $this->_getData('text');
    }

    public function getRating() {
        return $this->_getData('rating');
    }

    public function belongsToProduct($product) {
        return $this->getProduct() === $product;
    }

    public function getProduct() {
        return $this->_getData('product');
    }
}