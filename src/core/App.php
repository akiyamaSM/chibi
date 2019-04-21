<?php

namespace Chibi;

use Chibi\Auth\Auth;
use Chibi\ConfigManager;
use Chibi\Exceptions\ControllersMethodNotFound;
use Chibi\Exceptions\ControllerNotFound;
use Whoops\Handler\JsonResponseHandler;
use Whoops\Handler\PrettyPageHandler;
use Chibi\Hurdle\ShouldRedirect;
use Chibi\Router\Router;

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
            },
            'auth' => function () {
                return Auth::getInstance();
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
        $router = $this->container->router;
        $request = $this->container->request;
        $response = $this->container->response;
        $om = $this->container->om;
        $om->resolve(ConfigManager::class);
        $config = $this->container->config;

        $router->setPath(isset($_SERVER['PATH_INFO']) ?$_SERVER['PATH_INFO']: '/');

        // Get Hurdles that run on every request
        $this->runHurdles($this->getHurdles(), $request, $response, $om);

        // run specific Hurdles
        $this->runCustomHurdle($router->getHurdlesByPath());

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
            $specificInstance = app()->container->resolve($specific);
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
     * Run hurdles
     *
     * @param $specific
     * @throws \Exception
     */
    protected function runCustomHurdle($specific)
    {
        if(count($specific) === 0){
            return;
        }

        $specificInstance = app()->container->resolve($specific[0]);

        $extra  = count($specific['params']) === 0 ? [null] : $specific['params'];

        $params = app()->container->resolveMethod($specific[0], 'filter', $extra);

        if(!call_user_func_array([$specificInstance, 'filter'], $params)){
            if($specificInstance instanceof ShouldRedirect){
                header('Location:  '.  $specificInstance->redirectTo());
                return;
            }
            throw new \Exception("You don't have the rights to enter here", 1);
        }

    }



    /**
     * Process the Handler
     *
     * @param $callable
     * @param array $parames_all
     * @return mixed
     * @throws ControllerNotFound
     * @throws ControllersMethodNotFound
     * @throws Exceptions\ClassIsNotInstantiableException
     * @throws \ReflectionException
     */
    public function process($callable, $parames_all = [])
    {
        $om = $this->getContainer()->om;
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
        return require(BASE_PATH. DS .'app/Hurdles/register.php');
    }
}
