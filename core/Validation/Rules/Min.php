<?php


namespace Kolores\Validation\Rules;


class Min implements Checkable
{
    protected $min;

    public function __construct($min)
    {
        $this->min = $min;
    }

    /**
     * Check if the field is Min
     *
     * @param null $value
     * @return bool
     */
    function isValid($value = null)
    {
        if(strlen($value) >= $this->min){
            return true;
        }
        return false;
    }
}