<?php
//ini_set('display_errors', 1);

require_once __DIR__ . '/../src/models/Router.php';

$router = new Router($_GET['page']);

$controllerName = $router->getController();
$actionName = $router->getAction();

$controller = new $controllerName;
$controller->$actionName();
