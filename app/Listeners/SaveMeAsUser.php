<?php

namespace App\Listeners;

use Chibi\Events\Event;
use Chibi\Events\Listener;

class SaveMeAsUser extends Listener
{

    /**
     * @param Event $event
     * @return mixed
     */
    public function handle(Event $event)
    {
        var_dump("You are Saved. Thanks!");
        return true;
    }
}