<?php


namespace Kolores\Validation\Rules;


class Max implements Checkable
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
            return false;
        }
        return true;
    }
}