<?php

namespace Chibi\ObjectManager;

interface ObjectManagerInterface
{

    /**
     * Create new object instance
     *
     * @param string $classname
     * @param array $args
     * @return mixed
     */
    public function create($classname, array $args = []);

    /**
     * Resolve object instance
     *
     * @param string $classname
     * @return mixed
     */
    public function resolve($classname);
}
