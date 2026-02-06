<?php
namespace LazarusPhp\Foundation\Validation;

class IntRules
{
    public static function create():self
    {
        return new self();
    }

    public static function is(mixed $value):bool
    {
        return is_int($value);
    }
    
}