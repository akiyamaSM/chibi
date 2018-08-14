<?php

namespace Chibi\Router;

use BadMethodCallException;

trait Filtrable
{
    protected $filters = [];


    /**
     * Name a route
     *
     * @param $name
     */
    public function allow($className)
    {
        if ($this->isUriParsed()) {
            $className = is_array($className) ? $className : [$className];
            $this->filters[$this->parsedUri] = $className;
            return $this;
        }

        throw new BadMethodCallException(
        "Method allow can't be called Before setting the route"
        );
    }


    public function getHurdlesByPath($path = null){
        if(is_null($path)){
            $path = $this->path;
        }
        
        return isset($this->filters[$path]) ? $this->filters[$path] : [];
    }
}
