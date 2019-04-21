<?php


namespace Chibi\Validation\Rules;


class Required extends AbstractRule implements Checkable
{
    /**
     * Check if the field is Required
     *
     * @param null $value
     * @return bool
     */
    function isValid($value = null)
    {
        if(is_null($value) || empty($value)){

            $this->errorFound();

            return false;
        }

        return true;
    }

    function getError()
    {
        return "This field must not be empty";
    }
}