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
        if ($this->checkUnassingedVariables($value)) {
            throw new \Exception("variable <b>$".$value."</b> is undefined");
        }
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
    /**
     * [getTemplateVars description]
     * @return [type] [description]
     */
    public function getTemplateVars() {
        $matches = [];
        preg_match_all('/{{\s*(\$(.*?))\s*}}/', $this->contents,$matches);
        return isset($matches[2]) ? $matches[2] : [];
    }

    public function checkUnassingedVariables(&$value) {
        $diff = array_diff($this->getTemplateVars(),array_keys($this->vars));
        if (count($diff) > 0)  {

            $value = array_values($diff)[0];
        }
        return count($diff) > 0;
    }
}