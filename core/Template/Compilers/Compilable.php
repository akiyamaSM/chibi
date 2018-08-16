<?php


namespace Kolores\Template\Compilers;


interface Compilable {

    /**
     * Compile the template
     *
     * @param $content
     * @return mixed
     */
    public function compile($content);
}