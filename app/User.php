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
}