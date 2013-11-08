<?php
//ini_set('display_errors', 1);

require_once __DIR__ . '/../src/models/Router.php';
require_once __DIR__ . '/../src/controllers/ErrorController.php';

$router = new Router($_GET['page']);

$controllerName = $router->getController();
$actionName = $router->getAction();
$controller = null;
$notFoundError = false;

if (file_exists(__DIR__ . "/../src/controllers/{$controllerName}.php")) {
    require_once __DIR__ . "/../src/controllers/{$controllerName}.php";
    if(!class_exists($controllerName) || !in_array($actionName, get_class_methods($controllerName))) {
        $notFoundError = true;
    }
} else {
    $notFoundError = true;
}

if($notFoundError) {
    $controllerName = 'ErrorController';
    $actionName = 'pageNotFoundAction';
}

$controller = new $controllerName;
$controller->$actionName();
