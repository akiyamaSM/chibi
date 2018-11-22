<?php


namespace Kolores\Validation\Rules;


abstract class AbstractRule
{
    protected $isError = false;

    /**
     * Check if an error is found
     *
     * @return bool
     */
    public function hasError()
    {
        return $this->isError;
    }

    /**
     * Mark that an error is found
     */
    public function errorFound()
    {
        $this->isError = true;
    }

    abstract function getError();

}