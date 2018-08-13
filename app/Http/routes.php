<?php

use Chibi\Request;

$router->get('/user/{user}/{name}', 'App\Controllers\HomeController@views')->named('customers');
$router->get('/customers', 'App\Controllers\HomeController@index');
$router->get('/test', function() {
    $object = new StdClass();
    $object->name = "Houssain";
    dump(getenv('NAME'));
    dump($object);
});
$router->get('/hola/{name}', function($name, $h) {
    echo route('customers', [
        $name, 'two'
    ]);
})->named('Hola');
