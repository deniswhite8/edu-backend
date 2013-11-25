<?php
ini_set('display_errors', 1);

require_once __DIR__ . '/../src/models/Router.php';
require_once __DIR__ . '/../src/controllers/ErrorController.php';

$controllerName = '';
$actionName = '';

try {
    $router = new Router($_GET['page']);
    $controllerName = $router->getController();
    $actionName = $router->getAction();
} catch (PageNotFoundException $ex) {
    $controllerName = 'ErrorController';
    $actionName = 'pageNotFoundAction';
} catch (Exception $ex) {
    die();
}

$controller = new $controllerName;
$controller->$actionName();
