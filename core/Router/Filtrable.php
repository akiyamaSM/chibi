<?php

namespace Chibi\Router;

use BadMethodCallException;

trait Filtrable
{
    protected $filters = [];


    /**
     * Name a route
     *
     * @param $alias
     * @return $this
     * @throws \Exception
     * @internal param $name
     */
    public function allow($alias)
    {
        try{
            $className = $this->getAliasFromConfig($alias);
            if (is_null($className)) {
                throw new \Exception("No Hurdle with the Alias of {$alias} exists");
            }
            if ($this->isUriParsed()) {
                $className = is_array($className) ? $className : [$className];
                $this->filters[$this->parsedUri] = $className;
                return $this;
            }

            throw new BadMethodCallException(
            "Method allow can't be called Before setting the route"
            );
        }catch (\Exception $e){
            echo $e->getMessage();
            die();
        }
    }

    public function getHurdlesByPath($path = null){
        if(is_null($path)){
            $path = $this->path;
        }
        
        return isset($this->filters[$path]) ? $this->filters[$path] : [];
    }

    public function getAliasFromConfig($alias) {
        $config = include('config/alias.php');
        return isset($config['hurdles'][$alias])? $config['hurdles'][$alias] : null;
    }
}
