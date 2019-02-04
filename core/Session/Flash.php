<?php

namespace Chibi\Session;


class Flash
{
    /**
     * Set the new session flash
     *
     * @param $key
     * @param $value
     */
    public static function put($key, $value)
    {
        Session::put("flash_{$key}", $value);
    }

    /**
     * Get the session flash
     *
     * @param $key
     * @param null $orNull
     * @return mixed
     */
    public static function get($key, $orNull = null)
    {
        return Session::get("flash_{$key}", $orNull);
    }

    /**
     * Forget a session flash
     *
     * @param $key
     */
    public static function forget($key)
    {
        Session::forget("flash_{$key}");
    }
}