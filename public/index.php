<?php

require '../bases.php';

require  BASE_PATH . DS . 'vendor'. DS .'autoload.php';
$app = new \Chibi\App();
$container = $app->getContainer();
$router = $container->router;
require_once BASE_PATH .'/app/Http/routes.php';

$app->run();
