<?php

namespace Chibi\Template;

use Chibi\Template\Compilers\ConditionCompiler;
use Chibi\Template\Compilers\CSRFCompiler;
use Chibi\Template\Compilers\PrintCompiler;
use Chibi\Template\Compilers\LoopCompiler;
use Chibi\Template\Compilers\RouteCompiler;

class Template {
    use DoesntUseUnassignedVars;

    protected $file;

    protected $vars = [];

    protected $contents = "";

    protected $compilers = [
        ConditionCompiler::class,
        LoopCompiler::class,
        PrintCompiler::class,
        CSRFCompiler::class,
        RouteCompiler::class,
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
     * Compile the view
     *
     * @return $this
     */
    public function compile()
    {
        $this->parseVariables();
        $this->contents = file_get_contents($this->file);
        foreach($this->compilers as $compiler){
            $this->contents = (new $compiler($this->vars))->compile($this->contents);
        }
        return $this;
    }

    /**
     * Echo out the compiled code
     */
    public function render()
    {
        extract($this->vars);
        eval(' ?>' .$this->contents. '<?php ') ;
    }
}