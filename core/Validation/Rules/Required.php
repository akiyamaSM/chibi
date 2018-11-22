<?php


namespace Kolores\Validation\Rules;


class Required implements Checkable
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
            return false;
        }

        return true;
    }
}