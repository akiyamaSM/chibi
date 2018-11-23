<?php


namespace Kolores\Validation;


use Kolores\Validation\Rules\CustomConstraint;
use Kolores\Validation\Rules\Max;
use Kolores\Validation\Rules\Min;
use Kolores\Validation\Rules\Number;
use Kolores\Validation\Rules\Required;

class Rule{

    protected $key;

    protected $constraints = [];

    public function getFieldName(){
        return $this->key;
    }
    public function  __construct($key){
        $this->key = $key;
    }

    public function required()
    {
        $this->constraints[] = new Required();

        return $this;
    }

    public function unique()
    {
        return $this;
    }

    public function max($value)
    {
        $this->constraints[] = new Max($value);

        return $this;
    }

    public function min($value)
    {
        $this->constraints[] = new Min($value);

        return $this;
    }

    public function number()
    {
        $this->constraints[] = new Number();

        return $this;
    }

    public function inject(CustomConstraint $customConstraint)
    {
        $this->constraints[] = $customConstraint;

        return $this;
    }
    public function validate($value)
    {
        foreach ($this->constraints as $constraint){
            if($constraint->isValid($value) === false){
                return false;
            }
        }

        return true;
    }

    public function getConstraints()
    {
        return $this->constraints;
    }
}