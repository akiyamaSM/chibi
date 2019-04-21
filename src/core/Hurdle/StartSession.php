<?php

namespace Chibi\Hurdle;


use Chibi\Request;
use Chibi\Response;
use Chibi\Session\Session;

class StartSession implements Wall
{

    /**
     * Start the session
     *
     * @param Request $request
     * @param Response $Response
     * @return bool
     * @throws \Exception
     */
    public function filter(Request $request, Response $Response)
    {
        Session::start();

        return true;
    }
}