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

$app->get('/home', function(){
    echo "Home";
});
$app->post('/homes', function(){
    echo "Homes";
});
$app->map('/users', function(){
    echo "users";
}, ['GET', 'POST']);


$app->run();