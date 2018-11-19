<?php

namespace Kolores\Hurdle;


use Kolores\Request;
use Kolores\Response;

class CSRFTokenable implements Wall
{

    /**
     *
     * @param Request $request
     * @param Response $Response
     * @return bool
     * @throws \Exception
     */
    public function filter(Request $request, Response $Response)
    {
        if($request->isPost() && ($token = $request->has('csrf_token'))){
            if( get_crsf_token() === $token){
                return true;
            }
        }
        throw new \Exception("TokenMismatchException");
    }
}