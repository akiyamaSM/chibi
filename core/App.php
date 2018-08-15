<?php

namespace Chibi;

use Chibi\Router\Router;
use Chibi\Exceptions\ControllerNotFound;
use Chibi\Exceptions\ControllersMethodNotFound;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

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
                $om = AppObjectManager::getInstance();
                return $om->resolve(Router::class);
            },
            'response' => function(){
                $om = AppObjectManager::getInstance();
                return $om->resolve(Response::class);
            },
            'request' => function(){
                $om = AppObjectManager::getInstance();
                return $om->resolve(Request::class);
            },
            'om' => function () {
                return AppObjectManager::getInstance();
            }
        ));
        $this->registerApp();
    }

    /**
     * Get the App instance
     *
     * @return mixed
     */
    public static function getInstance()
    {
        return static::$instance;
    }

    /**
     * Register the App instance
     */
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
        $this->runWhoops();
        $router = $this->container->router;
        $request = $this->container->request;
        $response = $this->container->response;
        $om = $this->container->om;
        $router->setPath(isset($_SERVER['PATH_INFO']) ?$_SERVER['PATH_INFO']: '/');
        try {
            // Get Hurdles that run on every request 
            $hurdles = $this->getHurdles();

            foreach ($hurdles as $hurdle) {
                $instance = $om->resolve($hurdle);
                if (!$instance->filter($request, $response)) {
                    throw new \Exception("You don't have the rights to enter here", 1);
                }
            }

            // run specific Hurdles
            $specificHurdles = $router->getHurdlesByPath();
            foreach ($specificHurdles as $specific) {
                $specificInstance = $om->resolve($specific);
                if (!$specificInstance->filter($request, $response)) {
                    throw new \Exception("You don't have the rights to enter here", 1);
                }
            }
            $res =$router->getResponse();
            $response = $res['response'];
            $params = $res['parames'];
            return $this->respond($this->process($response, $params));
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    public function runWhoops()
    {
        $om = AppObjectManager::getInstance();
        $whoops = $om->resolve(Run::class);
        $whoops->pushHandler($om->resolve(PrettyPageHandler::class));
        $whoops->register();
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
        $parames_all = $parames;

        if (is_callable($callable)) {
            return call_user_func_array($callable,
                $this->getContainer()->resolveMethod('', $callable, $parames_all)
            );
        }
        if (is_string($callable)) {
            $array = explode('@', $callable);
            $class = $array[0];

            if (!class_exists($class)) {
                throw new ControllerNotFound("{$class} Controller Not Found");
            }
            $om = AppObjectManager::getInstance();
            $caller = $om->resolve($class);
            $method = $array[1];
            if (!method_exists($caller, $method)) {
                throw new ControllersMethodNotFound("{$method} Not Found in the {$class} Controller");
            }

            return call_user_func_array(
                [$caller, $method],
                $this->getContainer()->resolveMethod($class, $method, $parames_all)
            );
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


    protected function getHurdles(){
        return require('app/Hurdles/register.php');
    }
}