<?php


namespace App;

use Chibi\Auth\Authenticated;

class User extends Authenticated
{
    static $table = 'users';

    /**
     * The guard name
     *
     * @return string
     */
    function guard(): string
    {
        return 'users';
    }

    /**
     * The hashed password to be used
     *
     * @param $password
     * @return string
     */
    public static function  hash($password): string
    {
        return md5($password);
    }

}