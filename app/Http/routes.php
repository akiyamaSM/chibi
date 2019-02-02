<?php

use App\Constraints\UserName;
use Chibi\App;
use Chibi\Auth\Auth;
use Chibi\Request;
use Chibi\Validation\Rule;
use Chibi\Validation\Validator;

$router->get('/user', 'App\Controllers\HomeController@views')->named('customers');

$router->get('/configs', 'App\Controllers\HomeController@testConfig');

$router->get('/test', function() {
    Auth::against('users')->loginWith(1);
    dd(Auth::against('users')->user());
    dd(
        $_SESSION
    );

    $toLogin = \App\User::find(1);
    dump($toLogin->forceLogging()->check());
    dump(App::getInstance()->getContainer()->auth);
    $om = App::getInstance()->getContainer()->om;
    /* @var $om Chibi\ObjectManager\ObjectManager */
    $dispatcher = $om->resolve(\Chibi\Events\Dispatcher::class);
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

/*$router->get('/katana', function () {
    dump(\App\Friend::all());
    die();
    return view('token');
});*/

$router->get('/katana', function () {
    $data = [
        'name' => 'Inani',
        'age' => 20,
        'username' => 'Houssa_in'
    ];

    $validator = new Validator($data);

    $validator
        ->addRule(
        (
            new Rule('name'))->required()->max(10)->min(2)
        )
        ->addRule(
            (new Rule('age'))->required()->number()
        )->addRule(
            (new Rule('username'))->inject( new UserName())
        );

    dump($validator->check(), $validator->getErrors());
})->named('test_csrf');

$router->get('/ageNotOk', function (){
    return "Age NOT OK";
})->named('not_ok_age');