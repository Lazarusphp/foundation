<?php

namespace LazarusPhp\Foundation\Validation;

use Exception;
use LogicException;

class IntRules
{

    // ---- Properties ---- //

    private int|null $minValue = null;
    private int|null $maxValue = null;
    private int|null $matchValue = null;
    private int|null $randomValue = null;





    // ---- Contructor ---- //

    public function __construct()
    {
        $this->reset();
    }


    // ---- static Method for Instantiation ---- //

    public static function create()
    {
        return new self();
    }

    public function random(int $min,int $max):int
    {
        return rand($min,$max);
    }



    public function min(int $value)
    {
        if($this->minValue !== null)
        {
            throw new LogicException("Minimum Method Has Been set");
        }

        $this->minValue = $value;
        return $this;
    }

    public function max(int $value)
    {

        if($this->maxValue !== null)
        {
            throw new LogicException("Maximum Method has Been set ALready");
        }

        $this->maxValue = $value;
        return $this;
    }

    public function match(int $value)
    {

        if($this->matchValue !== null)
        {
            throw new LogicException("Match Method has Been set ALready");
        }

        $this->matchValue = $value;
        return $this;
    }

    public function validate($value):bool {
        
        $min = $this->minValue ?? null;
        $max = $this->maxValue ?? null;
        $match = $this->matchValue ?? null;
        $random = $this->randomValue ?? null;


        if(!$this->isInt($value))
        {
            throw new LogicException("Value $value is not an integer, ".gettype($value)." has been used");
        }

     


        if($min !== null && !$this->ValidateMin($min,$value))
        {
            throw new LogicException("Value : $value is lower than Minumum value $min");
        }
        

        if($max !== null && !$this->ValidateMax($max,$value))
        {
            throw  new LogicException("Value : $value is greater than the Maximum value $max");
        }

        if($match !== null && !$this->ValidateMatch($match,$value))
        {
            throw  new LogicException("Value $value does not match expected $match");
        }


        return true;

    }


    // ---- Private Functions ---- //

    private function isInt($value): bool
    {
        return is_int($value);
    }

    private function ValidateMin(int $min,$value):bool
    {
        return $value >= $min;    
    }

    

    private function ValidateMatch($match,$value)
    {
        return $match === $value;
    }


    private function ValidateMax(int $max , int $value):bool
    {
        return $value <= $max;
    }


    public function reset():self
    {
        $this->minValue = null;
        $this->maxValue = null;
        $this->randomValue = null;
        $this->matchValue = null;
        return $this;
    }
}
