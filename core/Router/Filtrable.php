<?php

namespace Chibi\Router;

use BadMethodCallException;

trait Filtrable
{
    protected $filters = [];


    /**
     * Parse the Alias
     *
     * @param $alias
     * @return array
     */
    protected function parseHurdleName($alias)
    {
        $parts = explode(':', $alias);

        return [
            $parts[0],
            isset($parts[1]) ? explode(',', $parts[1]) : []
        ];
    }

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
            list($alias, $params) = $this->parseHurdleName($alias);
            $className = $this->getAliasFromConfig($alias);
            if (is_null($className)) {
                throw new \Exception("No Hurdle with the Alias of {$alias} exists");
            }
            if ($this->isUriParsed()) {
                $className = is_array($className) ? $className : [$className];
                $this->filters[$this->parsedUri] = $className;
                $this->filters[$this->parsedUri]['params'] = $params;
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
        $config = include( BASE_PATH .DS .'config/alias.php');
        return isset($config['hurdles'][$alias])? $config['hurdles'][$alias] : null;
    }
}
