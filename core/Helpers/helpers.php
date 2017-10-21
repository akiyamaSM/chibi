<?php
use Chibi\App;
use Chibi\Exceptions\ViewNotFoundException;

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

if (! function_exists('view')) {
    /**
     * Pass data to the view
     *
     * @param $view
     * @param array $variables
     * @throws ViewNotFoundException
     */
    function view($view, $variables = [])
    {
        if(! file_exists("app/views/{$view}.chibi.php")){
            throw new ViewNotFoundException("The {$view} view is not found");
        }
        extract($variables);
        require_once("app/views/{$view}.chibi.php");
    }
}