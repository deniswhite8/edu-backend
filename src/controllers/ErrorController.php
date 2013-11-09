<?php

class ErrorController {
    public function pageNotFoundAction() {
        header('HTTP/1.0 404 Not Found');

        $_page = __DIR__ . '/../views/pageNotFound.phtml';
        include(__DIR__ . '/../views/main.phtml');
    }
}
