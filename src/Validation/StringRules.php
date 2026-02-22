<?php

namespace LazarusPhp\Foundation\Validation;

use LogicException;
use LazarusPhp\Foundation\Validation\Enums\StringCases;
use LazarusPhp\Foundation\ErrorHandler\Errors;
use LazarusPhp\Foundation\Validation\Traits\ErrorTrait;
use LazarusPhp\Foundation\Validation\Traits\IntegerTraits;

final class StringRules
{
    protected ?StringCases $case = null;

    use IntegerTraits;


    // Prevents Being called as an instance and must be called via Create
    private function __construct()
    {
        
    }

    public static function create()
    {
        return new self();
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

        if ($this->minValue !== null && !$this->minLength($string, $this->minValue)) {
            throw new LogicException("Value $string  does not meet Minimum Requirements of {$this->minValue} Charcters");
        }

        // Only enforce max if max < PHP_INT_MAX
        if ($this->maxValue !== null && !$this->maxLength($string, $this->maxValue)) {    
            throw new LogicException("{$string} Exceeds Maxium Required value of {$this->maxValue}");
        }

   if ($this->minValue !== null && $this->maxValue !== null && $this->minValue > $this->maxValue) {
    throw new LogicException("Minimum value cannot be larger than Maximum value");
}
    return true;
    }

}
