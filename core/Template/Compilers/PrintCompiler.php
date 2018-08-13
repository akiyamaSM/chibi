<?php

namespace Chibi\Template\Compilers;


class PrintCompiler implements Compilable {

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

        preg_match_all('/{{\s*(\$(.*?))\s*}}/', $content, $matches);

        $echos = $matches[0];

        foreach($echos as $key => $echo){
                $content = str_replace($echo, "<?php echo {$matches[1][$key]}; ?>", $content);
        }
        
        return $content;
    }
}