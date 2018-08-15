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
     * @var Factory
     */
    protected $factory = [];

    /**
     * Constructor
     */
    public function __construct(Factory $factory)
    {
        $this->factory = $factory;
        $this->instances[Chibi\ObjectManager\ObjectManagerInterface::class] = $this;
    }

    /**
     * Resolve object instance
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
                $this->instances[$classname] = $this->factory->create($classname);
            }
        }
        return $this->instances[$classname];
    }
}
