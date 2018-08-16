<?php

use Kolores\Request;
use Kolores\App;

$router->get('/user', 'App\Controllers\HomeController@views')->allow('YearIsCurrent')->named('customers');
$router->get('/customers', 'App\Controllers\HomeController@index');
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

$router->get('/testa', function() {
    $om = App::getInstance()->getContainer()->om;
    /* @var $om Kolores\ObjectManager\ObjectManager */
    $testClass = $om->resolve(\App\Test\Test::class);
})->named('testa');
