<?php

namespace App;

class App{

    protected $container;

    /**
     *  Construct
     */
    public function __construct()
    {
        $this->container = new Container([
            'router' => function(){
                return new Router;
            }
        ]);
    }

    /**
     * Get container instance
     *
     * @return Container
     */
    public function getContainer()
    {
        return $this->container;
    }

    public function get($uri, $handler)
    {
        $this->container->router->addRoute($uri, $handler);
    }

    public function run()
    {
        $router = $this->container->router;
        $router->setPath($_SERVER['PATH_INFO'] ?$_SERVER['PATH_INFO']: '/');
        $response = $router->getResponse();
        $this->process($response);
    }

    public function process($callable)
    {
        return $callable();
    }
}