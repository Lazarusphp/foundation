<?php 
namespace LazarusPhp\ErrorHandler;

final class Errors
{
    private array $errors = [];



    public function __construct()
    {
        $this->errors = [];
    }

    public function addError($error)
    {
        $this->errors[] = $error;
    }

    public function hasErrors():int
    {
        return count($this->errors);
    }

    public function returnErrors():array|bool
    {
        if($this->hasErrors())
        {
            return $this->errors;   
        }
        return false;
    }

    public function resetErrors()
    {
        $this->errors = [];
    }

}