<?php


namespace Kolores\Validation;

class Validator
{
    protected $data = [];

    protected $rules = [];

    public function  __construct($data){
        $this->data = $data;
    }

    public function addRule(Rule $rule)
    {
        $this->rules[$rule->getFieldName()] = $rule;

        return $this;
    }

    /**
     * Check if its valid
     *
     * @return bool
     */
    public function check()
    {
        foreach ($this->data as $field => $value){
            if($this->rules[$field]->validate($value) === false ){
                return false;
            }
        }
        return true;
    }
}


