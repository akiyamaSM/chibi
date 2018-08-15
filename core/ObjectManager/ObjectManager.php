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
     * Retrieve cached object instance
     *
     * @param string $classname
     * @return mixed
     */
    public function resolve($classname)
    {
        $di = [];
        $classname = ltrim($classname, '\\');
        //$type = @$di[$type];
        if (!isset($this->instances[$classname])) {
            if (class_exists($classname)) {
                $this->instances[$classname] = new $classname();
            }
        }
        return $this->instances[$classname];
    }
}
