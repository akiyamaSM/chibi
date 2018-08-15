<?php

use Chibi\Request;
use Chibi\App;

$router->get('/user', 'App\Controllers\HomeController@views')->allow(App\Hurdles\YearIsCurrent::class)->named('customers');
$router->get('/customers', 'App\Controllers\HomeController@index');
$router->get('/test', function() {
    $object = new StdClass();
    $object->name = "Houssain";
    bdump(env('NAME'),$object,env('NAME'),$object);
});
$router->get('/hola/{name}', function($name, $h) {
    echo route('customers', [
        $name, 'two'
    ]);
})->named('Hola');

$router->get('/testa', function() {
    $om = App::getInstance()->getContainer()->om;
    $homeController = $om->resolve(\App\Controllers\HomeController::class);
    echo get_class($homeController);

})->named('Hola');
