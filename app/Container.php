<?php

namespace App;

use ArrayAccess;

class Container implements ArrayAccess {

    protected $items = [];
    protected $cache = [];

    public function offsetGet($offset)
    {
        if(!$this->has($offset)){
            return;
        }
        if(isset($this->cache[$offset])){
            return $this->cache[$offset];
        }

        $item = $this->items[$offset]($this);
        $this->cache[$offset] = $item;
        return $item;
    }

    public function offsetSet($offset, $value)
    {
        $this->items[$offset] = $value;
    }

    public function offsetUnset($offset)
    {
        if($this->has($offset)){
            unset($this->items[$offset]);
        }
    }

    public function offsetExists($offset)
    {
        return isset($this->items[$offset]);
    }

    public function has($offset)
    {
        return $this->offsetExists($offset);
    }

    public function __get($value)
    {
        return $this->offsetGet($value);
    }
}