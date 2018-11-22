<?php

namespace Kolores;

use Kolores\Exceptions\ControllersMethodNotFound;
use Kolores\Exceptions\ControllerNotFound;
use Whoops\Handler\JsonResponseHandler;
use Whoops\Handler\PrettyPageHandler;
use Kolores\Hurdle\ShouldRedirect;
use Kolores\Router\Router;

class App
{
    /**
     * @var App 
     */
    protected static $instance;

    /**
     * @var Container 
     */
    protected $container;

    /**
     *  Construct
     */
    public function __construct()
    {
        $this->runWhoops();
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
     * @return App
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
     * @throws \Exception
     */
    public function run()
    {
        session_start();
        $router = $this->container->router;
        $request = $this->container->request;
        $response = $this->container->response;
        $om = $this->container->om;
        $om->resolve(\Kolores\ConfigManager::class);
        $config = $this->container->config;

        $router->setPath(isset($_SERVER['PATH_INFO']) ?$_SERVER['PATH_INFO']: '/');

        // Get Hurdles that run on every request
        $this->runHurdles($this->getHurdles(), $request, $response, $om);

        // run specific Hurdles
        $this->runHurdles($router->getHurdlesByPath(), $request, $response, $om);

        $res =$router->getResponse();
        $response = $res['response'];
        $params = $res['parames'];
        $this->respond($this->process($response, $params));
    }

    /**
     * Run Whoops
     */
    protected function runWhoops()
    {
        $run = new \Whoops\Run;
        $handler = new PrettyPageHandler;
        $handler->setPageTitle("There was a problem.");
        $run->pushHandler($handler);
        if (\Whoops\Util\Misc::isAjaxRequest()) {
          $run->pushHandler(new JsonResponseHandler);
        }
        $run->register();
    }


    /**
     * Run hurdles
     *
     * @param $hurdles
     * @param $request
     * @param $response
     * @param $om
     * @throws \Exception
     */
    protected function runHurdles($hurdles, $request, $response, $om)
    {
        foreach($hurdles as $specific){
            $specificInstance = $om->resolve($specific);
            if(!$specificInstance->filter($request, $response)){
                if($specificInstance instanceof ShouldRedirect){
                    header('Location:  '.  $specificInstance->redirectTo());
                    break;
                }
                throw new \Exception("You don't have the rights to enter here", 1);
            }
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
     * @throws Exceptions\ClassIsNotInstantiableException
     * @throws \ReflectionException
     */
    public function process($callable, $parames = [])
    {
        $om = $this->getContainer()->om;
        $parames_all = $parames;
        $om = AppObjectManager::getInstance();
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

    /**
     * Get hurdles
     */
    protected function getHurdles(){
        return require('app/Hurdles/register.php');
    }
}
