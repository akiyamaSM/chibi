<?php

namespace Chibi\Router;

use BadMethodCallException;
use Chibi\Controller\Controller;
use ReflectionClass;

trait RouteParser
{
    /**
     * @var boolean 
     */
    protected $parsedUri = false;

    /**
     * Make Get request
     *
     * @param $uri
     * @param $handler
     * @return self
     */
    public function get($uri, $handler)
    {
        try {
            $this->checkIfNotValideHandler($handler);
        } catch (\Exception $e) {
            die($e->getMessage());
        }
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
        if ($this->isUriParsed()) {
            $this->names[$name] = $this->parsedUri;

            $this->parsedUri = false;
            return $this;
        }

        throw new BadMethodCallException(
            "Method Name can't be called Before setting the route"
        );
    }

    public function isUriParsed()
    {
        return $this->parsedUri != false;
    }

    public function checkIfNotValideHandler($handler)
    {
        if (is_callable($handler)) {
            return;
        }

        return $this->getClass($handler);
    }

    protected function getClass($handler)
    {
        $string = explode('@', $handler);

        if (count($string) !== 2) {
            throw new \Exception("Not the Good Syntax");
        }
        $class = $string[0];
        if (!class_exists($class)) {
            throw new \Exception("Class {$class} Not found");
        }
        $object = new ReflectionClass($class);
        if (!$object->isSubclassOf(Controller::class)) {
            throw new \Exception("Class {$class} is not a controller");
        }

        return;
    }
}
