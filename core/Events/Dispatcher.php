<?php

namespace Chibi\Events;


class Dispatcher {

    protected $listeners = [];

    /**
     * Push handler into list of listeners
     *
     * @param $event
     * @param $handler
     * @return $this
     */
    public function addListeners($event, $handler)
    {
        $this->listeners[$event][] = $handler;
        return $this;
    }

    /**
     * Check if the event has listeners
     * 
     * @param $event
     * @return bool
     */
    public function hasListeners($event)
    {
        return isset($this->listeners[$event]);
    }

    /**
     * Get Listeners based on the name of Event
     *
     * @param $event
     * @return array
     */
    public function getListenersByEventName($event)
    {
        if(! $this->hasListeners($event)){
            return [];
        }

        return $this->listeners[$event];
    }

    /**
     * Run the listeners
     *
     * @param $event
     */
    public function dispatch($event)
    {
        foreach($this->getListenersByEventName($event->getName()) as $action){
            $continue = $action->handle($event);
            if(!$continue){
                break;
            }
        }
    }
}