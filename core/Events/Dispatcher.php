<?php

namespace Chibi\Events;

class Dispatcher
{
    /**
     * Array of listeners
     *
     * @var array
     */
    protected $listeners = [];

    /**
     * Push handler into list of listeners
     *
     * @param string $event
     * @param Listener $handler
     * @param int $priority
     * @return $this
     */
    public function addListener($event, $handler, $priority = 0)
    {
        if ($handler instanceof Listener) {
            $this->listeners[$event][$priority][] = $handler;
        }
        return $this;
    }

    /**
     * Remove handler from list of listeners
     *
     * @param string $event
     * @return $this
     */
    public function removeListener($event)
    {
        if (empty($this->listeners[$event])) {
            return;
        }
        unset($this->listeners[$event]);
        return $this;
    }

    /**
     * Check if the event has listeners
     * 
     * @param string $event
     * @return bool
     */
    public function hasListeners($event)
    {
        return isset($this->listeners[$event]);
    }

    /**
     * Get Listeners based on the name of vent
     *
     * @param string $event
     * @return array
     */
    public function getListenersByEventName($event)
    {
        if (!$this->hasListeners($event)) {
            return [];
        }

        return array_filter($this->listeners[$event]);
    }

    /**
     * Run the listeners
     *
     * @param string $event
     * @return $this
     */
    public function dispatch($event)
    {
        foreach ($this->getListenersByEventName($event->getName()) as $action) {
            $continue = $action->handle($event);
            if (!$continue) {
                break;
            }
        }
        return $this;
    }
}
