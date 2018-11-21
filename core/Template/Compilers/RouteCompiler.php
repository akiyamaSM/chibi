<?php

namespace Kolores\Template\Compilers;


class RouteCompiler implements Compilable {

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
        $content = preg_replace('/@route_to\((.*)\)/', '<?php echo route($1) ?>', $content);
        return $content;
    }
}