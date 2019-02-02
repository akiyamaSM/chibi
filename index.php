<?php
define('BASE_PATH', __DIR__);
define('DS', DIRECTORY_SEPARATOR);
define('APP_PATH', BASE_PATH . DS . 'app' );
define('CORE_PATH', BASE_PATH . DS . 'core');

require  BASE_PATH . DS . 'vendor'. DS .'autoload.php';

$app = new \Chibi\App();
$container = $app->getContainer();
$router = $container->router;

require_once 'app/Http/routes.php';

$app->run();
