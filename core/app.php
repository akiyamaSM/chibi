<?php

namespace Chibi;

use Chibi\Router\Router;
use Chibi\Exceptions\ControllerNotFound;
use Chibi\Exceptions\ControllersMethodNotFound;

class App{

    static $instance;

    protected $container;

    /**
     *  Construct
     */
    public function __construct()
    {
        $this->container = new Container(array(
            'router' => function(){
                return new Router;
            },
            'response' => function(){
                return new Response();
            },
            'request' => function(){
                return new Request();
            }
        ));
        $this->registerApp();
    }

    public static function getInstance()
    {
        return static::$instance;
    }
    public function registerApp()
    {
        static::$instance = $this;
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
            $res =$router->getResponse();
            $response = $res['response'];
            $parames = $res['parames'];
            return $this->respond($this->process($response, $parames));
        }catch (\Exception $e){
            echo $e->getMessage();
        }
    }

    /**
     * Process the Handler
     *
     * @param $callable
     * @param array $parames
     * @return mixed
     * @throws ControllerNotFound
     * @throws ControllersMethodNotFound
     */
    public function process($callable, $parames = [])
    {
        $response = $this->container->response;
        $request = $this->container->request;

        $parames_all = [$request, $response];

        if(count($parames) > 0){
            foreach($parames as $param){
                array_unshift($parames_all, $param);
            }
        }
        if(is_callable($callable)){
            return call_user_func_array($callable, $parames_all);
        }
        if(is_string($callable)){
            $array = explode('@', $callable);
            $class = $array[0];

            if(! class_exists($class)){
                throw new ControllerNotFound("{$class} Controller Not Found");
            }

            $caller = $this->getContainer()->resolve($class);
            $method = $array[1];
            if(!method_exists($caller, $method)){
                throw new ControllersMethodNotFound("{$method} Not Found in the {$class} Controller");
            }
            return call_user_func_array([$caller, $method], $parames_all);
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

        $response->applyHeaders();

        echo $response->getBody();
    }
}