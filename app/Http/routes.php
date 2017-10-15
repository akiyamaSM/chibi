<?php
$router->get('/home/user', 'App\Controllers\HomeController@index');
$router->get('/home/json', 'App\Controllers\HomeController@json');

$router->get('/home', 'App\Controllers\HomeController@views');
