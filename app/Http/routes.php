<?php
$router->get('/home/user', 'App\Controllers\HomeController@index');
$router->get('/home/json', 'App\Controllers\HomeController@json');

$router->post('/home', function(){
    echo 'Posted';
});
