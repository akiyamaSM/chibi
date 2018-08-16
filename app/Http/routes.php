<?php

use Chibi\Request;
$router->get('/hola/{name}', function($name, $h) {
    echo route('customers', [
        $name, 'two'
    ]);
})->named('Hola');

$router->get('/user', 'App\Controllers\HomeController@views')->allow('YearIsCurrent')->named('customers');
$router->get('/customers', 'App\Controllers\HomeController@index');
$router->get('/test', function() {
    $dispatcher = new \Chibi\Events\Dispatcher();
    $name = "Houssain";
    $dispatcher->addListeners("EntredLinkEvent", new App\Listeners\SayHello());
    $dispatcher->addListeners("EntredLinkEvent", new App\Listeners\SaveMeAsUser());
    $dispatcher->dispatch( new \App\Events\EntredLinkEvent($name));
})->named('test');

