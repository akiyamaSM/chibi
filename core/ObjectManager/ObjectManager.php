<?php

namespace Chibi\ObjectManager;

class ObjectManager implements ObjectManagerInterface
{
    /**
     * List of instances
     *
     * @var array
     */
    protected $instances = [];

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->instances[Chibi\ObjectManager\ObjectManager::class] = $this;
    }

    /**
     * Retrieve cached object instance
     *
     * @param string $classname
     * @return mixed
     */
    public function resolve($classname)
    {
        $di = [];//@todo get all di from a config
        $classname = ltrim($classname, '\\');
        //$classname = $di[$classname];
        if (!isset($this->instances[$classname])) {
            if (class_exists($classname)) {
                $this->instances[$classname] = new $classname();
            }
        }
        return $this->instances[$classname];
    }
}
