<?php

namespace Kolores\ObjectManager;

class ObjectManager implements ObjectManagerInterface, \ArrayAccess
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
        $this->instances[Kolores\ObjectManager\ObjectManagerInterface::class] = $this;
    }

    /**
     * Create new object instance
     *
     * @param string $classname
     * @param array $args
     * @return mixed
     */
    public function create($classname, array $args = [])
    {
        $di = [];//@todo get all di from a config
        $classname = ltrim($classname, '\\');
        return $this->factory->create($classname, $args);
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
        if(array_key_exists($classname, $di)) {
            $classname = $di[$classname];
        }
        if (!$this->offsetExists($classname)) {
            if (class_exists($classname)) {
                $this->offsetSet($classname, $this->factory->create($classname));
            }
        }
        return $this->offsetGet($classname);
    }

    /**
     * Check if offset exists
     *
     * @param string $offset
     * @return boolean
     */
    public function offsetExists($offset)
    {
        return isset($this->instances[$offset]);
    }

    /**
     * Get the offset
     *
     * @param string $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return isset($this->instances[$offset]) ? $this->instances[$offset] : null;
    }

    /**
     * Set the offset
     *
     * @param string $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        $this->instances[$offset] = $value;
    }

    /**
     * Unset the offset
     *
     * @param type $offset
     */
    public function offsetUnset($offset)
    {
        unset($this->instances[$offset]);
    }
}
