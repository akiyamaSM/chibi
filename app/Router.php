<?php


namespace App;


class Router {

    protected $routes = [];

    protected $path;

    public function setPath($path = '/')
    {
        $this->path = $path;
        return $this;
    }
    public function addRoute($uri, $handler)
    {
        $this->routes[$uri] = $handler;
    }

    public function getResponse()
    {
        return $this->routes[$this->path];
    }
}