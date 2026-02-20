<?php

namespace LazarusPhp\Foundation\Validation;

use LogicException;
use LazarusPhp\Foundation\Validation\Enums\StringCases;
use LazarusPhp\Foundation\ErrorHandler\Errors;
use LazarusPhp\Foundation\Validation\Traits\ErrorTrait;
use LazarusPhp\Foundation\Validation\Traits\IntegerTraits;

final class StringRules
{

    private Errors $errors;
    protected ?StringCases $case = null;
    use ErrorTrait;
    use IntegerTraits;


    // Prevents Being called as an instance and must be called via Create
    private function __construct(?Errors $errors=null)
    {
            $this->errors = $errors ?? new Errors();
    }

    public static function create(?Errors $errors=null)
    {
        $errors = $errors ?? new Errors();
        return new self($errors);
    }

    public function minLength(string $string, int $min): bool
    {
        return (mb_strlen($string) >= $min) ? true : false;
    }

    public function maxLength(string $string, int $max): bool
    {
        return mb_strlen($string) <= $max ? true : false;
    }


    public function validate(string $string):bool
    {

        $this->errors->reset();
      
        if ($this->minValue !== null && !$this->minLength($string, $this->minValue)) {
            $this->errors->add("min","Value $string  does not meet Minimum Requirements of {$this->minValue} Charcters");
        }

        // Only enforce max if max < PHP_INT_MAX
        if ($this->maxValue !== null && !$this->maxLength($string, $this->maxValue)) {    
            $this->errors->add("max","{$string} Exceeds Maxium Required value of {$this->maxValue}");
        }

   if ($this->minValue !== null && $this->maxValue !== null && $this->minValue > $this->maxValue) {
    $this->errors->add("config", "Minimum value cannot be larger than Maximum value");
}
    return $this->isValid();
    }

}
