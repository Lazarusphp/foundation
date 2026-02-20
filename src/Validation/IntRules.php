<?php

namespace LazarusPhp\Foundation\Validation;

use Exception;
use LogicException;
use LazarusPhp\Foundation\ErrorHandler\Errors;
use LazarusPhp\Foundation\Validation\Traits\ErrorTrait;
use LazarusPhp\Foundation\Validation\Traits\IntegerTraits;

class IntRules
{

    // ---- Properties ---- //

    private int|null $matchValue = null;
    private Errors $errors;
    use ErrorTrait;
    use IntegerTraits;




    // ---- Contructor ---- //

    private function __construct($errors)
    {
        $this->errors = $errors;
        $this->reset();
    }


    // ---- static Method for Instantiation ---- //

    public static function create(?Errors  $errors=null)
    {
        $errors  = $errors ?? new Errors();
        return new self($errors);
    }


    public function match(int $value):self
    {

        if($this->matchValue !== null)
        {
            $this->errors->add("logic","Match Method has Been set ALready");
        }

        $this->matchValue = $value;
        return $this;
    }

    public function validate(int $value):bool {
        
        $this->clearErrors();
        $match = $this->matchValue ?? null;
   
        if($this->minValue !== null && !$this->validateMin($this->minValue,$value))
        {
            $this->errors->add("min","Value : $value is lower than Minumum value $this->minValue");
        }
        

        if($this->maxValue !== null && !$this->validateMax($this->maxValue,$value))
        {
            $this->errors->add("max","Value : $value is greater than the Maximum value $this->maxValue");
        }

        if($match !== null && !$this->validateMatch($match,$value))
        {
            $this->errors->add("match","Value $value does not match expected $match");
        }

        return $this->isValid();
       
    }


    // ---- Private Functions ---- //

    private function validateMin(int $min,$value):bool
    {
        return $value >= $min;    
    }

    

    private function validateMatch($match,$value)
    {
        return $match === $value;
    }


    private function validateMax(int $max , int $value):bool
    {
        return $value <= $max;
    }


    public function reset():self
    {
        $this->minValue = null;
        $this->maxValue = null;
        $this->matchValue = null;
        return $this;
    }
}