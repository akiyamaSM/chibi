<?php

namespace Chibi\Template\Compilers;


class CSRFCompiler implements Compilable {

    /**
     * Construct
     *
     * @param array $vars
     */
    public function __construct($vars = [])
    {
        $this->vars = $vars;
    }

    /**
     * Compile if statement
     *
     * @param $content
     * @return mixed
     */
    public function compile($content)
    {
        $token = \Chibi\Session\Session::get('csrf_token', null);

        if(is_null($token)){
            $token = \Chibi\Session\Session::put('csrf_token', substr(
                    base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 32)
            );
        }

        $content = preg_replace('/@csrf_field/', "
                <input type='hidden' name='csrf_token' value='$token' />
            ", $content);
        return $content;
    }
}