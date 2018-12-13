<?php


namespace Kolores\Validation\Rules;


class Min extends AbstractRule implements Checkable
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

        $this->errorFound();

        return false;
    }

    /**
     * Get error message
     *
     * @return string
     */
    public function getError()
    {
        return "Value must be greater than {$this->min}";
    }
}