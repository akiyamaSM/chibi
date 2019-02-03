<?php

namespace App\Hurdles;

use Chibi\Hurdle\ShouldBeGuest;

class RedirectIfAuthenticated extends ShouldBeGuest
{

    /**
     * Redirect to a page
     *
     * @return mixed
     */
    public function redirectTo()
    {
        return route('home_online');
    }
}