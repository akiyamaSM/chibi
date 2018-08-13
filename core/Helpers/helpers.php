<?php

use Chibi\App;
use Chibi\Exceptions\ViewNotFoundException;
use Chibi\Template\Template;

if (!function_exists('route')) {

    /**
     * Get the route path
     *
     * @param $name
     * @param array $params
     * @return mixed
     */
    function route($name, $params = [])
    {
        $router = app()->getContainer()->router;

        return $router->getUrlOfNamedRoute($name, $params);
    }
}


if (!function_exists('app')) {

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

if (!function_exists('view')) {

    /**
     * Pass data to the view
     *
     * @param $view
     * @param array $variables
     * @throws ViewNotFoundException
     */
    function view($view, $variables = [])
    {
        if (!(file_exists("app/views/{$view}.chibi.php"))) {
            throw new ViewNotFoundException("The {$view} view is not found");
        }
        $template = new Template("app/views/{$view}.chibi.php");
        $template->fill($variables)->compileView()->render();
        //require_once("app/views/{$view}.chibi.php");
    }
}
if (!function_exists('redirect')) {

    /**
     * Redirect to a specific path
     *
     * @param $path
     */
    function redirect($path)
    {
        header("Location: /{$path}");
    }
}