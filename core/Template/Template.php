<?php

namespace Chibi\Template;

use Chibi\Template\Compilers\ConditionCompiler;

class Template {

    protected $file;

    protected $vars = [];

    protected $contents = "";

    protected $compilers = [
        ConditionCompiler::class,
    ];

    /**
     * Generate the file
     *
     * @param $file
     */
    public function __construct($file)
    {
        $this->file = $file;
    }

    /**
     * Fill the variables
     *
     * @param array $vars
     * @return $this
     */
    public function fill($vars = [])
    {
        $vars = is_array($vars)? $vars : [$vars];
        $this->vars = $vars;

        return $this;
    }

    /**
     *  Compile the echo
     */
    public function compileEcho()
    {

        foreach($this->vars as $key => $value){
            $this->contents = preg_replace('/\{\{\s*\$'. $key .'\s*\}\}/', $value , $this->contents);
        }
        return $this;
    }


    /**
     * Compile the view
     *
     * @return $this
     */
    public function compileView()
    {
        $this->contents = file_get_contents($this->file);
        $this->compileEcho();

        foreach($this->compilers as $compiler){
            $this->contents = (new $compiler)->compile($this->contents);
        }
        return $this;
    }

    /**
     * Echo out the compiled code
     */
    public function render()
    {
        eval(' ?>' .$this->contents. '<?php ') ;
    }

}