<?php

namespace Chibi\Template;
class Template {

    protected $file;

    protected $vars = [];

    protected $contents = "";

    /**
     * Generate the file
     *
     * @param $file
     */
    public function __construct($file)
    {
        $this->file = $file;
    }

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


    public function compileView()
    {
        $this->contents = file_get_contents($this->file);
        $this->compileEcho();
        return $this;
    }

    /**
     * Echo out the compiled code
     */
    public function render()
    {
        echo $this->contents;
    }
}