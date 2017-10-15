<?php


namespace App\Routing;


trait RouteParser {

    /**
     * Make Get request
     *
     * @param $uri
     * @param $handler
     */
    public function get($uri, $handler)
    {
        $this->addRoute($uri, $handler, ['GET']);
    }

    /**
     * Make post request
     *
     * @param $uri
     * @param $handler
     */
    public function post($uri, $handler)
    {
        $this->addRoute($uri, $handler, ['POST']);
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
        $this->addRoute($uri, $handler, $methods);
    }
}