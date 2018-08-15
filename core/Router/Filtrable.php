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
    public function allow($alias)
    {
        $className = $this->getAliasFromConfig($alias);
        if (is_null($classNames)) {
            throw new \Exception("Error Processing Request", 1);
            
        }
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

    public function getAliasFromConfig($alias) {
        $config = include('config/Alias.php');
        return $config['hurdles'][$alias];
    }
}
