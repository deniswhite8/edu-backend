<?php
namespace App;

use App\Model\Hasher;

require_once __DIR__ . '/../autoloader.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);
date_default_timezone_set('Europe/Moscow');


try {
    $defaultPath = 'product_list';

    $routePath = isset($_GET['page']) ? $_GET['page'] : $defaultPath ;

    $router = new Model\Router($routePath);
    $controllerName = $router->getController();
    $actionName = $router->getAction();

    if (!class_exists($controllerName) || !method_exists($controllerName, $actionName)) {
        throw new Model\RouterException('Class or method are not exist');
    }

} catch (Model\RouterException $e) {
    $controllerName = '\App\Controller\ErrorController';
    $actionName = 'notFoundAction';
}
$di = new \Zend\Di\Di();
(new \App\Model\DiC($di))->assemble();

$controller = new $controllerName($di);

if ($view = $controller->$actionName()) {
    $view->render();
}




