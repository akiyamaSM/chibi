<?php

namespace App\Events;


abstract class Listener {
    /**
     * @param Event $event
     * @return mixed
     */
    abstract public function handle(Event $event);
}