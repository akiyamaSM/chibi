<?php


namespace Chibi\Router;


trait Nameable {

    protected $parames = [];

    protected $names =  [];


    /**
     * Get the list of Params
     *
     * @return array
     */
    public function getParames()
    {
        return $this->parames;
    }

    /**
     * Return the url of the route name
     *
     * @param $name
     * @param array $params
     * @return mixed
     * @throws RouteNameArgumentInvalidException
     * @throws RouteNameDoesntExistException
     */
    public function getUrlOfNamedRoute($name, $params)
    {
        $params = is_array($params)?$params: [$params];
        if(!$this->nameExists($name)){
            throw new RouteNameDoesntExistException("Route '{$name}' doesn't exist");
        }
        $old_uri = $this->names[$name];
        $uri = explode('/', $old_uri);
        array_shift($uri);

        if(count($uri) < count($params)){
            throw new RouteNameArgumentInvalidException("Number of arguments is invalid");
        }

        $namedParams = $this->getNamedParams($uri);
        if(count($namedParams) == 0){
            return $old_uri;
        }

        if(count($namedParams)!= count($params)){
            throw new RouteNameArgumentInvalidException("Number of arguments is invalid");
        }
        return $this->buildUrlByRouteAndParams($old_uri, $namedParams, $params);
    }

    /**
     * Get the Named params in the route definition
     *
     * @param $uri
     * @return array
     */
    public function getNamedParams($uri)
    {
        $params = [];

        foreach($uri as $part){
            if( preg_match('/^{.*.}$/', $part, $matches)){
                $params[] = $matches[0];
            }
        }
        return $params;
    }

    /**
     * Map the Uri
     *
     * @param $uri
     * @param $namedParams
     * @param $params
     * @return mixed
     */
    public function buildUrlByRouteAndParams($uri, $namedParams, $params)
    {
        for($i = 0; $i< count($namedParams); $i++){
            $uri = str_replace($namedParams[$i], $params[$i], $uri);
        }
        return $uri;
    }
    /**
     * Check if the route name exists
     *
     * @param $name
     * @return bool
     */
    public function nameExists($name)
    {
        return isset($this->names[$name]);
    }
}