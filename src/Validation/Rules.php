<?php
namespace LazarusPhp\Foundation\Validation;


final class Rules
{
    public static function create($classname,?array $errors=null)
    {
        $errors = $errors ?? null;
        if(class_exists($classname))
        {
            $class = explode("::",$classname);
            return $class[0]::create($errors);
        }
    }
}