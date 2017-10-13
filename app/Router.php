<?php

namespace App;

use App\Exceptions\HttpMethodNotAllowedException;
use App\Exceptions\HttpRouteNotFoundException;

class Router {

    protected $routes = [];

    protected $methods = [];

    protected $path;

    public function setPath($path = '/')
    {
        $this->path = $path;
        return $this;
    }

    public function addRoute($uri, $handler, $methods = ['GET'])
    {
        $this->routes[$uri] = $handler;
        $this->methods[$uri] = $methods;
    }

    public function getResponse()
    {
        if(!$this->has()){
            throw new HttpRouteNotFoundException("Http Route Not found");
        }

        if(!in_array($_SERVER['REQUEST_METHOD'], $this->methods[$this->path])){
            throw new HttpMethodNotAllowedException("Method not allowed");
        }
        return $this->routes[$this->path];
    }

    public function has()
    {
        return isset($this->routes[$this->path]);
    }
}