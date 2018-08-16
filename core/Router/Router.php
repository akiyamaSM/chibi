<?php

namespace Kolores\Router;

use Kolores\Exceptions\HttpMethodNotAllowedException;
use Kolores\Exceptions\HttpRouteNotFoundException;
use Kolores\Exceptions\RouteNameArgumentInvalidException;
use Kolores\Exceptions\RouteNameDoesntExistException;

class Router
{

    use RouteParser,
        Filtrable,
        Nameable;

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
     * Get the current path
     *
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Register the route
     *
     * @param $uri
     * @param $handler
     * @param array $methods
     * @return $this
     */
    public function addRoute($uri, $handler, $methods = ['GET'])
    {
        array_walk($methods, function($method) use ($handler, $uri) {
            $this->routes[$uri][$method] = $handler;
            $this->methods[$uri][] = $method;
        });

        $this->parsedUri = $uri;
        return $this;
    }

    /**
     * Return the handler
     *
     * @return mixed
     * @throws HttpMethodNotAllowedException
     * @throws HttpRouteNotFoundException
     */
    public function getResponse()
    {
        if (!($uri = $this->has())) {
            throw new HttpRouteNotFoundException("Http Route Not found");
        }

        if (!in_array($_SERVER['REQUEST_METHOD'], $this->methods[$uri])) {
            throw new HttpMethodNotAllowedException("Method not allowed");
        }
        return [
            'response' => $this->routes[$uri][$_SERVER['REQUEST_METHOD']],
            'parames' => $this->getParames()
        ];
    }

    /**
     * Check if the current uri exists
     *
     * @return bool
     */
    public function has()
    {
        $current = explode('/', $this->path);
        array_shift($current);
        foreach ($this->routes as $uri => $route) {
            $registred = explode('/', $uri);
            array_shift($registred);

            if (count($current) != count($registred)) {
                continue;
            }
            if ($this->hasParameters($current, $registred)) {
                return $uri;
            }
        }

        return false;
    }

    /**
     * Compare the current Uri against an other one
     *
     * @param array $current
     * @param array $registred
     * @return bool
     */
    public function hasParameters(array $current, array $registred)
    {
        $parames = [];
        for ($index = 0; $index < count($current); $index++) {
            if (!preg_match('/^{(.*.)}$/', $registred[$index], $matches)) {
                if (!($current[$index] === $registred[$index])) {
                    return false;
                }
            } else {
                $parames[$matches[1]] = $current[$index];
            }
        }
        $this->parames = $parames;
        return true;
    }
}
