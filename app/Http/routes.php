<?php

use Kolores\App;
use Kolores\Request;

$router->get('/user', 'App\Controllers\HomeController@views')->named('customers');

$router->get('/configs', 'App\Controllers\HomeController@testConfig');

$router->get('/test', function() {
    $om = App::getInstance()->getContainer()->om;
    /* @var $om Kolores\ObjectManager\ObjectManager */
    $dispatcher = $om->resolve(\Kolores\Events\Dispatcher::class);
    $name = "Houssain";
    $dispatcher->addListeners("EntredLinkEvent", $om->resolve(\App\Listeners\SayHello::class));
    $dispatcher->addListeners("EntredLinkEvent", $om->resolve(\App\Listeners\SaveMeAsUser::class));
    $dispatcher->dispatch($om->create(\App\Events\EntredLinkEvent::class, [$name]));
})->named('test');

$router->get('/hola/{name}', function($name, $h) {
    echo route('customers', [
        $name, 'two'
    ]);
})->named('Hola');

$router->get('/katana', function () {
    return view('token');
    //dump(\App\Friend::all());
});

$router->post('/katana', function (Request $request) {
    dump($request);
})->named('test_csrf');

$router->get('/ageNotOk', function (){
    return "Age NOT OK";
})->named('not_ok_age');