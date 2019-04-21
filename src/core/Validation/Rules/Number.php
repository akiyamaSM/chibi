<?php


namespace Chibi\Validation\Rules;


class Number extends AbstractRule implements Checkable
{

    /**
     * Check if is a number
     *
     * @param null $value
     * @return bool
     */
    function isValid($value = null)
    {
       if(is_numeric($value)){
           return true;
       }

       $this->errorFound();

       return false;
    }

    function getError()
    {
        return "this field must be numeric";
    }
}