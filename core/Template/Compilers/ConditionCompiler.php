<?php

namespace Chibi\Template\Compilers;


class ConditionCompiler {

    /**
     * Compile if statement
     *
     * @param $content
     * @return mixed
     */
    public function compile($content)
    {
        $content = preg_replace('/@when\((.*)\)/', '<?php if($1) : ?>', $content);
        $content = preg_replace('/@or\((.*)\)/', '<?php elseif($1) : ?>', $content);
        $content = preg_replace('/@otherwise/', '<?php else: ?>', $content);
        $content = preg_replace('/@stop/', '<?php endif; ?>', $content);

        return $content;
    }
}