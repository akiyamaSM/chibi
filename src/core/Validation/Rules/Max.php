<?php


namespace Chibi\Validation\Rules;


class Max extends AbstractRule implements Checkable
{
    protected $max;

    public  function __construct($max){
        $this->max = $max;
    }
    /**
     * Check if the field is Required
     *
     * @param null $value
     * @return bool
     */
    function isValid($value = null)
    {
        if(strlen($value) > $this->max){
            $this->errorFound();
            return false;
        }
        return true;
    }

    /**
     * The message error
     */
    function getError()
    {
        return "this field must be less than {$this->max}";
    }
}