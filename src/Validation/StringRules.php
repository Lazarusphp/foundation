<?php

namespace LazarusPhp\Foundation\Validation;

use LogicException;
use LazarusPhp\Foundation\Validation\Enums\StringCases;
use LazarusPhp\Foundation\ErrorHandler\Errors;

final class StringRules
{

    protected int $min = 0;
    protected int $max = PHP_INT_MAX;
    private Errors $errors;
    protected ?StringCases $case = null;

    public function __construct(?Errors $errors=null)
    {
            $this->errors = $errors ?? new Errors();
    }

    public static function create(?Errors $errors=null)
    {
        return new self(new Errors($errors));
    }

    public function minLength(string $string, int $min): bool
    {
        return (mb_strlen($string) >= $min) ? true : false;
    }

    public function maxLength(string $string, int $max): bool
    {
        return mb_strlen($string) <= $max ? true : false;
    }


    public function min(int $min)
    {
        $this->min = $min;
        return $this;
    }

    public function max(int $max)
    {
        $this->max = $max;
        return $this;
    }

    public function error(string $key)
    {
        return $this->errors->get($key);
    }

    public function errors():array
    {
        return $this->errors->all();
    }

    public function validate(string $string):bool
    {

        $this->errors->reset();
        if($this->min > $this->max)
        {
                $this->errors->add("config","Minimum Value cannot be larger than Max Value");
        }

        if ($this->min > 0 && !$this->minLength($string, $this->min)) {
            $this->errors->add("min","Value $string  does not meet Minimum Requirements of {$this->min} Charcters");
        }

        // Only enforce max if max < PHP_INT_MAX
        if ($this->max < PHP_INT_MAX && !$this->maxLength($string, $this->max)) {    
            $this->errors->add("max","{$string} Exceeds Maxium Required value of {$this->max}");
        }

            return ($this->errors->count()) ? false : true;    
    }

}
