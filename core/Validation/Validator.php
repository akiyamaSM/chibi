<?php


namespace Chibi\Validation;

class Validator
{
    protected $data = [];

    protected $rules = [];

    protected $isError = false;

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
                $this->isError = true;
            }
        }
        return !$this->isError;
    }

    /**
     * @param null $key
     * @return array
     * @throws \ReflectionException
     */
    public function getErrors($key = null)
    {
        if(!$this->isError){
            return [];
        }

        $errors = [];
        $keys = [$key];

        if(is_null($key)){
            $keys = array_keys($this->rules);
        }
        foreach ($keys as $key){
            $rule = $this->rules[$key];
            foreach ($rule->getConstraints() as $constraint){
                if($constraint->hasError()){
                    $errors[$key][strtolower(get_class_name($constraint))] = $constraint->getError();
                }
            }
        }
        return $errors;
    }
}


