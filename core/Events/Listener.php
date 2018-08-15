<?php

namespace Chibi\Events;

/**
 * @abstract
 */
abstract class Listener
{

    /**
     * @param Event $event
     * @return mixed
     */
    abstract public function handle(Event $event);
}
