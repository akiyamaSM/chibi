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
        array_walk($methods, function($method) use ($handler, $uri){
            $this->routes[$uri][$method] = $handler;
            $this->methods[$uri][] = $method;
        });
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
        return $this->routes[$this->path][$_SERVER['REQUEST_METHOD']];
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