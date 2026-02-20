<?php
namespace LazarusPhp\Foundation\Validation;

use LazarusPhp\Foundation\ErrorHandler\Errors;

final class Rules
{
    public static function create($classname,?Errors $errors = null)
    {
        $errors = $errors ?? null;
        if(class_exists($classname))
        {
            $class = explode("::",$classname);
            return $class[0]::create($errors);
        }
    }
}