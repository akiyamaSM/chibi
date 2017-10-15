<?php
$router->get('/home', 'App\Controllers\HomeController@index');

$router->post('/home', function(){
    echo 'Posted';
});
