<?php

namespace App\Events;

use Kolores\Events\Event;

class EntredLinkEvent extends Event{

    public $name;

    public function __construct($name)
    {
        $this->name = $name;
    }
}