<?php
use Chibi\Request;

$router->get('/user/{user}/{name}', 'App\Controllers\HomeController@views');
$router->get('/customers', 'App\Controllers\HomeController@index')->named('customers');
