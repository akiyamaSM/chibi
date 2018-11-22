<?php


namespace Kolores\Validation\Rules;


class Number implements Checkable
{

    /**
     * Check if is a number
     *
     * @param null $value
     * @return bool
     */
    function isValid($value = null)
    {
        return is_numeric($value);
    }
}