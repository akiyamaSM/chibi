<?php

namespace App;

use App\Exceptions\ControllersMethodNotFound;
use App\Exceptions\ControllerNotFound;
use App\Routing\Router;

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
            },
            'response' => function(){
                return new Response();
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

    /**
     * Run the App
     *
     * @throws ControllerNotFound
     * @throws ControllersMethodNotFound
     */
    public function run()
    {
        $router = $this->container->router;
        $router->setPath($_SERVER['PATH_INFO'] ?$_SERVER['PATH_INFO']: '/');
        try{
            $response = $router->getResponse();
            return $this->respond($this->process($response));
        }catch (\Exception $e){
            echo $e->getMessage();
        }
    }

    /**
     * Process the Handler
     *
     * @param $callable
     * @return mixed
     * @throws ControllerNotFound
     * @throws ControllersMethodNotFound
     */
    public function process($callable)
    {
        $response = $this->container->response;
        if(is_callable($callable)){
            return $callable($response);
        }
        if(is_string($callable)){
            $array = explode('@', $callable);
            $class = $array[0];

            if(! class_exists($class)){
                throw new ControllerNotFound("{$class} Controller Not Found");
            }

            $caller = new $class;
            $method = $array[1];
            if(!method_exists($caller, $method)){
                throw new ControllersMethodNotFound("{$method} Not Found in the {$class} Controller");
            }

            return call_user_func([$caller, $method], $response);
        }
    }

    /**
     * Echo out the response
     * 
     * @param $response
     */
    public function respond($response)
    {
        if(!$response instanceof Response){
            echo $response;
            return;
        }

        echo $response->getBody();
    }
}