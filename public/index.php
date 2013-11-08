<?php
//ini_set('display_errors', 1);

require_once __DIR__ . '/../src/models/Router.php';

$router = new Router($_GET['page']);

$controllerName = $router->getController();
$actionName = $router->getAction();
$controller = null;


if (!file_exists(__DIR__ . "/../src/controllers/{$controllerName}.php")) {
    $controllerName = 'ErrorController';
    require_once __DIR__ . "/../src/controllers/ErrorController.php";
} else {
    require_once __DIR__ . "/../src/controllers/{$controllerName}.php";
}

$controller = new $controllerName;
if (!method_exists($controller, $actionName)) {
    $actionName = 'pageNotFoundAction';
}

$controller->$actionName();
