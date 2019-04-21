<?php

namespace Chibi\Template\Compilers;


class FunctionCompiler implements Compilable {

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
        $content = preg_replace('/@@(.*\))/', '<?php echo $1 ?>', $content);
        return $content;
    }
}