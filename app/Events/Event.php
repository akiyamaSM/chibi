<?php

namespace App\Events;

use ReflectionClass;

abstract class Event {

    /**
     * Get the name of the class
     *
     * @return string
     */
    public function getName(){
        return (new ReflectionClass($this))->getShortName();
    }
}