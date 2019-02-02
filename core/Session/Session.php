<?php


namespace Chibi\Session;


class Session
{

    /**
     *  Start the session
     */
    public static function start()
    {
        session_start();
    }

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

    /**
     * Get the value of a session entry
     *
     * @param $key
     * @return mixed
     */
    public static function forget($key)
    {
        if(isset($_SESSION[$key])){
             unset($_SESSION[$key]);
        }
    }


    /**
     *  Stop the session
     *
     */
    public static function stop()
    {
        session_destroy();
    }
}