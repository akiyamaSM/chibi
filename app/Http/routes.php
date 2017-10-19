<?php
use Chibi\Request;

$router->get('/user/{user}/{name}', 'App\Controllers\HomeController@views')->named('customers');
$router->get('/customers', 'App\Controllers\HomeController@index');

$router->get('/hola/{name}', function(){
    echo route('customers', [
        'one', 'two'
    ]);
    echo "<br>";
    echo route('Hola', 'Houssain');
})->named('Hola');