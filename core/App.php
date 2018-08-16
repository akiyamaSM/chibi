<?php

namespace Kolores;

use Kolores\Hurdle\ShouldRedirect;
use Kolores\Router\Router;
use Kolores\Exceptions\ControllerNotFound;
use Kolores\Exceptions\ControllersMethodNotFound;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Handler\JsonResponseHandler;

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
     */
    public function run()
    {
        $router = $this->container->router;
        $request = $this->container->request;
        $response = $this->container->response;
        $om = $this->container->om;
        /* @var $om Kolores\ObjectManager\ObjectManager */
        $om->resolve(\Kolores\ConfigManager::class);
        $config = $this->container->config;

        $router->setPath(isset($_SERVER['PATH_INFO']) ?$_SERVER['PATH_INFO']: '/');
        // Get Hurdles that run on every request
        $hurdles = $this->getHurdles();

        foreach ($hurdles as $hurdle) {
            $instance = $om->resolve($hurdle);
            if (!$instance->filter($request, $response)) {
                if ($instance instanceof ShouldRedirect) {
                    // do some Magic in here
                    break ;
                }
                throw new \Exception("You don't have the rights to enter here", 1);
            }
        }
        // run specific Hurdles
        $specificHurdles = $router->getHurdlesByPath();
        foreach($specificHurdles as $specific){
            $specificInstance = $om->resolve($specific);
            if(!$specificInstance->filter($request, $response)){
                if($specificInstance instanceof ShouldRedirect){
                    $specificInstance->redirectTo();
                    return ;
                }
                throw new \Exception("You don't have the rights to enter here", 1);
            }
        }

        $res =$router->getResponse();
        $response = $res['response'];
        $params = $res['parames'];
        return $this->respond($this->process($response, $params));
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
        $om = $this->getContainer()->om;
        /* @var $om Kolores\ObjectManager\ObjectManager */
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
     *
     * @return type
     */
    protected function getHurdles(){
        return require('app/Hurdles/register.php');
    }
}
