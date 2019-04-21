<?php


namespace Chibi\Controller;


use Chibi\Validation\Validator;

trait CanValidate
{
    /**
     * The data to validate
     * 
     * @param $data
     * @return Validator
     */
    public function validate(array $data)
    {
        return new Validator($data);
    }
}