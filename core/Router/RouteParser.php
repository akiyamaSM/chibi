<?php


namespace Chibi\Router;


use BadMethodCallException;

trait RouteParser {

    protected $parsedUri = false;

    /**
     * Make Get request
     *
     * @param $uri
     * @param $handler
     */
    public function get($uri, $handler)
    {
        return $this->addRoute($uri, $handler, ['GET']);
    }

    /**
     * Make post request
     *
     * @param $uri
     * @param $handler
     */
    public function post($uri, $handler)
    {
        return $this->addRoute($uri, $handler, ['POST']);
    }

    /**
     * Make requests with many methods
     *
     * @param $uri
     * @param $handler
     * @param array $methods
     */
    public function map($uri, $handler, $methods = ['GET'])
    {
        return $this->addRoute($uri, $handler, $methods);
    }

    /**
     * Name a route
     *
     * @param $name
     */
    public function named($name)
    {
        if($this->isUriParsed()){
            $this->names[$this->parsedUri] = $name;

            $this->parsedUri = false;
            return;
        }
        throw new BadMethodCallException(
            "Method Name can't be called Before setting the route"
        );
    }

    public function isUriParsed()
    {
        return $this->parsedUri != false;
    }
}