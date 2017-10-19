<?php
use Chibi\App;

if (! function_exists('route')) {
    function route($name, $params = [])
    {
        $router = app()->getContainer()->router;

        return $router->getUrlOfNamedRoute($name, $params);
    }
}


if (! function_exists('app')) {
    /**
     * Get The instance of the Application
     *
     * @return mixed
     */
    function app()
    {
        return App::getInstance();
    }
}