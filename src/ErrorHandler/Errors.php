<?php 
namespace LazarusPhp\Foundation\ErrorHandler;

use LogicException;

class Errors
{
    private array $errors = [];

    public function add(string $key, string $message): void
    {        
        $this->errors[$key] = $message;
    }

    public function reset()
    {
            $this->errors = [];
    }


    public function has(string $key):bool
    {
        return (array_key_exists($key,$this->errors));
    }    

    public function get(?string $key)
    {
        return $this->errors[$key] ?? null;
    }

    public function all():array
    {
        return $this->errors;
    }


    public function count():int
    {
        return count($this->errors);
    }
}
