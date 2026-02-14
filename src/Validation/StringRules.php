<?php

namespace LazarusPhp\Foundation\Validation;

use LogicException;
use LazarusPhp\Foundation\Validation\Enums\StringCases;



final class StringRules
{

    protected int $min = 0;
    protected int $max = PHP_INT_MAX;
    protected ?StringCases $case = null;

    public static function create()
    {
        return new self();
    }

    public static function is(mixed $value): bool
    {
        return is_string($value) ? true : false;
    }

    public static function minLength(string $string, int $min): bool
    {
        return (mb_strlen($string) >= $min) ? true : false;
    }

    public static function maxLength(string $string, int $max): bool
    {
        return mb_strlen($string) <= $max ? true : false;
    }

    public  static function subString(string $string, $min, $max)
    {
        return substr($string, $min, $max);
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

    public function validate(string $string):bool
    {
        if (!self::is($string)) {
            throw new LogicException("Validation Failed  : Value is not a string");
        }
        
        $string = $this->applyCase($string);
       
        if ($this->min > 0 && !self::minLength($string, $this->min)) {
            throw new LogicException("Value does not meet the Minimum character length of {$this->min}");
        }

        // Only enforce max if max < PHP_INT_MAX
        if ($this->max < PHP_INT_MAX && !self::maxLength($string, $this->max)) {
            throw new LogicException("Value exceeds the Maximum character length of {$this->max}");
        }

        return true;
    }

    private function setCase(StringCases $stringcase)
    {
        if($this->case !== null)
        {
            throw new LogicException("A Method has alreay been set ");
        }

        $this->case = $stringcase;
        return $this;
    }

    public function upper()
    {
        $this->setCase(StringCases::UPPER);
        return $this;
    }

    public function lower()
    {
        $this->setCase(StringCases::LOWER);
        return $this;
    }

    public function lcFirst()
    {
        $this->setCase(StringCases::LCFIRST);
        return $this;
    }

        public function ucFirst()
    {
        $this->setCase(StringCases::UCFIRST);
        return $this;
    }

    private function mblclower(string $string):string
    {
        $first = mb_substr($string,0,1);
        $rest = mb_substr($string,1);
        return mb_strtolower($first) . $rest;

    }

    private function applyCase($string)
    {;
        return match($this->case)
        {
            StringCases::LOWER => mb_strtolower($string),
            StringCases::UPPER => mb_strtoupper($string),
            StringCases::UCFIRST => mb_convert_case($string,MB_CASE_TITLE),
            StringCases::LCFIRST=> $this->mblclower($string),
            null => $string,
        };
    }
}
