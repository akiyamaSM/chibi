<?php


namespace Chibi\Session;


class Session
{

    /**
     * Create/Update a session entry
     *
     * @param $key
     * @param $value
     * @return mixed
     */
    public static function put($key, $value)
    {
        $_SESSION[$key] = $value;

        return $value;
    }

    /**
     * Get the value of a session entry
     *
     * @param $key
     * @param $whenNull
     * @return mixed
     */
    public static function get($key, $whenNull = null)
    {
        if(isset($_SESSION[$key])){
            return $_SESSION[$key];
        }

        return $whenNull;
    }
}