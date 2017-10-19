<?php
use Chibi\Request;

$router->get('/user/{user}/{name}', 'App\Controllers\HomeController@views')->named('customers');
$router->get('/customers', 'App\Controllers\HomeController@index');

$router->get('/hola/{name}', function($name){
    echo route('customers', [
        $name, 'two'
    ]);
})->named('Hola');