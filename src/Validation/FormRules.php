<?php
namespace LazarusPhp\Foundation\Validation;

use LazarusPhp\Foundation\ErrorHandler\Errors;
use LazarusPhp\Foundation\Validation\Traits\ErrorTrait;
use LogicException;

class FormRules
{

    // ---- Properties ---- //

    private bool|null $requiredValue = null;
    private string|int|null $matchValue = null;
    private array $requestMethod = [];

    // ---- Constructor ---- //

    private function __construct()
    {
        $this->detectMethod();
        $this->reset();
    }

    public static function create()
    {
        return new self();
    }

    public function matches($input)
    {
        

        if($this->matchValue !== null)
        {
            throw new LogicException("Logic Exception : ".__FUNCTION__." has Been Used Already");
        }
        else{
            $this->matchValue = $input;
        }
        return $this;
    }


 private function validateMatch($input): bool
{
    return isset(
        $this->requestMethod[$this->matchValue],
        $this->requestMethod[$input]
    ) && $this->requestMethod[$this->matchValue] === $this->requestMethod[$input];

}

    public function required()
    {
        if ($this->requiredValue !== null) {
            throw new LogicException("required() has already been set");
        }

        $this->requiredValue = true;
        return $this;
    }

private function validateRequired($input): bool
{
    return isset($this->requestMethod[$input])
        && trim((string)$this->requestMethod[$input]) !== '';
}


    public function submit($name)
    {
        return isset($this->requestMethod[$name]) ? true : false;
    }


    public function validate(string $input)
    {  
    
        if ($this->matchValue === $input) {
            throw new LogicException("Field cannot match itself");
        }

        if ($this->matchValue && !$this->validateRequest($this->matchValue)) {
            throw new LogicException("Field {$this->matchValue} does not exist");
        }

        if (!$this->validateRequest($input)) {
            throw new LogicException("Field $input does not exist");
        }
        
        if($this->requiredValue && !$this->validateRequired($input))
        {
            throw new LogicException("The Field $input is Required");
        }

        if($this->matchValue !== null && !$this->validateMatch($input))
        {
            throw new LogicException("$input Must match {$this->matchValue}");
        }

        $this->reset();
    }
    public function detectMethod()
    {
        $this->requestMethod = ($_SERVER["REQUEST_METHOD"] === "POST") ? $_POST:$_GET; 
    }

    public function request(string $name)
    {
        return ($this->validateRequest($name)) ?  $this->requestMethod[$name] : "";
    }


    public function validateRequest(string $name):bool
    {
        if(!isset($this->requestMethod[$name]))
        {
          return false;
        }
        // 
        return true;
     
    }

    private function reset()
    {
        // Work on this later
        $this->requiredValue = null;
        $this->matchValue = null;
    }

}