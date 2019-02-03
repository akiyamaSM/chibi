<?php

namespace App\Hurdles;

use Chibi\Hurdle\ShouldAuthenticate;

class RedirectIfGuest extends ShouldAuthenticate
{

    /**
     * Redirect to a page
     *
     * @return mixed
     */
    public function redirectTo()
    {
        return route('home_guest');
    }
}