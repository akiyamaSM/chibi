<?php

namespace App\Listeners;

use Kolores\Events\Event;
use Kolores\Events\Listener;

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