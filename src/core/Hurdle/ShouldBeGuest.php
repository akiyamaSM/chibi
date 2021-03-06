<?php

namespace Chibi\Hurdle;


use Chibi\Auth\Auth;
use Chibi\Request;
use Chibi\Response;

abstract class ShouldBeGuest implements Wall, ShouldRedirect
{

    /**
     * Filter the Form inputs
     *
     * @param Request $request
     * @param Response $Response
     * @return bool
     * @throws \Exception
     */
    public function filter(Request $request, Response $Response)
    {
        if(Auth::guest()){
            return true;
        }
        return false;
    }
}