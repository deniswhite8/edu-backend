<?php

require_once __DIR__ . '/vendor/autoload.php';
$loader = new \Zend\Loader\StandardAutoloader;


$loader->registerNamespace(
    'App\Model',
    __DIR__ . '/src/models'
);
$loader->register();

$router = new \App\Model\Router('...');