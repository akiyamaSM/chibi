<?php
$router->get('/home/user', 'App\Controllers\HomeController@index');

$router->post('/home', function(){
    echo 'Posted';
});
