<?php

require 'vendor/autoload.php';

$app = new Chibi\App();

$container = $app->getContainer();

$container['config'] = function () {
    return [
        'db_driver' => 'mysql',
        'db_host' => 'localhost',
        'db_name' => 'market',
        'db_user' => 'root',
        'db_password' => '',
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