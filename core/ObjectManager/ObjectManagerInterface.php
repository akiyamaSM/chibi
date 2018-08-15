<?php

namespace Chibi\ObjectManager;

interface ObjectManagerInterface
{

    /**
     * Retrieve loaded instance
     *
     * @param string $classname
     * @return mixed
     */
    public function resolve($classname);
}
