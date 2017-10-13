<?php

namespace App;

class App{

    protected $container;

    /**
     *  Construct
     */
    public function __construct()
    {
        $this->container = new Container;
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
}