<?php

namespace App\Routing;

use App\Exceptions\HttpMethodNotAllowedException;
use App\Exceptions\HttpRouteNotFoundException;

class Router {
    use RouteParser;

    protected $routes = [];

    protected $methods = [];

    protected $path;

    /**
     * Set the current path
     *
     * @param string $path
     * @return $this
     */
    public function setPath($path = '/')
    {
        $this->path = $path;
        return $this;
    }

    /**
     * Register the route
     *
     * @param $uri
     * @param $handler
     * @param array $methods
     */
    public function addRoute($uri, $handler, $methods = ['GET'])
    {
        $this->routes[$uri] = $handler;
        $this->methods[$uri] = $methods;
    }

    /**
     * Show the response
     *
     * @return mixed
     * @throws HttpMethodNotAllowedException
     * @throws HttpRouteNotFoundException
     */
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

    /**
     * Check if the current uri exists
     *
     * @return bool
     */
    public function has()
    {
        return isset($this->routes[$this->path]);
    }
}