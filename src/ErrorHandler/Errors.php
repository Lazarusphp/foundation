<?php 
namespace LazarusPhp\Foundation\ErrorHandler;

final class Errors
{
    private array $errors = [];



    public function __construct(array $errors)
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

    public function listErrors():array
    {
        return $this->errors;
    }

    public function resetErrors()
    {
        $this->errors = [];
    }

}