<?php

require 'vendor/autoload.php';

$app = new App\App();

$container = $app->getContainer();

$container['config']= function (){
  return [
      'db_driver' => 'mysql',
      'db_host' => 'localhost',
      'db_name' => 'chibi',
      'db_user' => 'root',
      'db_password' => '',
  ];
};

$container['db']= function($container){
    return new PDO(
        $container->config['db_driver'].':dbname='.$container->config['db_name'].';host='.$container->config['db_host'],
        $container->config['db_user'],
        $container->config['db_password']
    );
};
$router = $container->router;

require_once 'app\Http\routes.php';

$app->run();