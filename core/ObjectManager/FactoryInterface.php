<?php

namespace Chibi\ObjectManager;

interface FactoryInterface
{
    /**
     * Create instance with arguments
     *
     * @param string $className
     * @param array $args
     * @return \Closure
     */
    public function create($className, array $args = []);
}
