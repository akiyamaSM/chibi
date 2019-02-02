<?php


namespace App\Constraints;


use Chibi\Validation\Rules\CustomConstraint;

class UserName extends CustomConstraint
{

    function getError()
    {
        return "Field should contain an (_)";
    }

    function isValid($value = null)
    {
        if(strstr($value, '_') === false){
            $this->errorFound();
            return false;
        }

        return true;
    }
}