<?php

namespace App\Events;

use Chibi\Events\Event;

class EntredLinkEvent extends Event{

    public $name;

    public function __construct($name)
    {
        $this->name = $name;
    }
}