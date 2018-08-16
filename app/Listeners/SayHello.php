<?php

namespace App\Listeners;

use Kolores\Events\Event;
use Kolores\Events\Listener;

class SayHello extends Listener
{

    /**
     * @param Event $event
     * @return mixed
     */
    public function handle(Event $event)
    {
        var_dump("Hello " . $event->name);
        return true;
    }
}