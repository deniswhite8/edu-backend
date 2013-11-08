<?php

class ErrorController {
    public function pageNotFoundAction() {
        header('HTTP/1.0 404 Not Found');
        require_once __DIR__ . '/../views/pageNotFound.phtml';
    }
}
