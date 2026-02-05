<?php

namespace LazarusPhp\Foundation\Validation;

use LogicException;
use Symfony\Polyfill\Mbstring\Mbstring;

final class StringRules
{

    protected int $min;
    protected int $max;

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

    public function validate(string $string)
    {
        if (!self::is($string)) {
            throw new LogicException("Validation Failed  : Value is not a string");
        }
        $min = $this->min ?? 0;
        $max = $this->max ?? PHP_INT_MAX;

        if ($min > 0 && !self::minLength($string, $min)) {
            throw new LogicException("Value does not meet the Minimum character length of $min");
        }

        // Only enforce max if max < PHP_INT_MAX
        if ($max < PHP_INT_MAX && !self::maxLength($string, $max)) {
            throw new LogicException("Value exceeds the Maximum character length of $max");
        }

        return true;
    }
}
