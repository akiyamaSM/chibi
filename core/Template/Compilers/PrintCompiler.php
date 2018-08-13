<?php

namespace Chibi\Template\Compilers;


class PrintCompiler implements compilable {

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
        foreach($this->vars as $key => $value){
            $content = preg_replace('/\{\{\s*\$'. $key .'\s*\}\}/', $value , $content);
            $content = preg_replace('/\$'. $key .'/', $value , $content);
        }
        return $content;
    }
}