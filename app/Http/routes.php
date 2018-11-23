<?php

use App\Constraints\UserName;
use Kolores\App;
use Kolores\Request;
use Kolores\Validation\Rule;
use Kolores\Validation\Validator;

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