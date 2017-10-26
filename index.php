<?php

require 'vendor/autoload.php';
$dotenv = new Dotenv();
$dotenv->load(__DIR__);
$app = new Chibi\App();

$container = $app->getContainer();

$container['config'] = function () {
    return [
        'db_driver' => getenv('DB_DRIVER'),
        'db_host' => getenv('DB_HOST'),
        'db_name' => getenv('DB_DATABASE'),
        'db_user' => getenv('DB_USERNAME'),
        'db_password' => getenv('DB_PASSWORD'),
    ];
};

$container['db'] = function ($container) {
    return new Javanile\Moldable\Database([
        'host'     => $container->config['db_host'],
        'dbname'   => $container->config['db_name'],
        'username' => $container->config['db_user'],
        'password' => $container->config['db_password'],
        'prefix'   => '',
        'debug'    => false,
    ]);
};

Javanile\Moldable\Context::registerContainer($container);

$router = $container->router;

require_once 'app\Http\routes.php';

$app->run();