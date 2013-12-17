<?php
namespace App\Controller;

class ProductReviewController
    extends ActionController
{
    public function addAction()
    {
        if ($this->_validRequest()) {
            $data = $_POST;
            unset($data['review_id']);
            unset($data['token']);

            $review = $this->_di->get('ProductReview', ['data' => $data]);
            $review->save();

            $this->_redirect('product_view', ['id' => $data['product_id']]);
        } else {
            $this->_redirect('product_list');
        }
    }

    private function _validRequest()
    {
        return isset($_POST['token']) && isset($_POST['name']) && isset($_POST['text']) && isset($_POST['rating']) &&
        $_POST['name'] !== '' && $_POST['text'] !== '' && $_POST['rating'] !== '' &&
        !ctype_space($_POST['name']) && !ctype_space($_POST['text']) && !ctype_space($_POST['rating']) &&

            $this->_di->get('Session')->validateToken($_POST['token']);
    }
}
