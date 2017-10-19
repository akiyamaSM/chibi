<?php
use Chibi\App;

if (! function_exists('route')) {
    function route()
    {
        $app = app();
        var_dump($app->getContainer()->router);
    }
}


if (! function_exists('app')) {
    function app()
    {
        return App::getInstance();
    }
}