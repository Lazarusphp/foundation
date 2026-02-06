<?php
namespace LazarusPhp\Foundation\Validation;

use LogicException;

final class ArrayRules
{

    private array|string|int|null $key = null;
    private array|string|int|null $in = null;

    private static array $invalidKeys = [];
    private static array $invalidValues = [];

    public static function create():self
    {
        return new self();
    }

    public static function is($value):bool
    {
        return is_array($value);
    }

    public static function inArray(array|string|int $values, array $array):bool
    {
        if(is_array($values))
        {
            foreach($values as $value)
            {
                if (!in_array($value, $array, true)) 
                {
                    return false;
                }            
            }
            return true;
        }

        return in_array($values,$array);
    }

public static function hasKeys(array|string|int $keys, array $array):bool
{
    if (is_array($keys)) {
        foreach ($keys as $key) {
            if (!array_key_exists($key, $array)) return false;
        }
        return true;
    }
    return array_key_exists($keys, $array);
}


    public function key(array|string|int $key):self
    {
        if($this->key !== null)
        {
            throw new LogicException("Key has already been Set");
        }

        $this->key = $key;
        return $this;
    }

    public function validate(array $value):bool
    {
        if(!self::is($value))
        {
            throw new LogicException("Validation Failed : Value Must be an array");
        }

        if($this->key !== null  && !self::hasKeys($this->key,$value))
        {
            throw new LogicException("Key is not part of the selected Array");
        }

        return true;
    }

    public function in(string|int|array $value)
    {
        $this->in = $value;
        return $this;
    }
}