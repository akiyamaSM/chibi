<?php
use Chibi\Request;

$router->get('/user/{user}/{name}', 'App\Controllers\HomeController@views');
$router->get('/customers', 'App\Controllers\HomeController@index');

$router->get('/test', function(Request $request){
    var_dump($request->name);
});
