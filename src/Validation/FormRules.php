<?php
namespace LazarusPhp\Foundation\Validation;

use LogicException;

class FormRules
{

    // ---- Properties ---- //

    private bool|null $requiredValue = null;
    private string|int|null $matchValue = null;

    // ---- Constructor ---- //

    public function __construct()
    {
        $this->reset();
    }

    // ---- Static Instantiation ---- //

    public static function create()
    {
        return new self();
    }

    // ---- Public Methods ---- //

    public function required():self
    {
        if($this->requiredValue !== null)
        {
            throw new LogicException("Required has Already Been Set");
        }

        $this->requiredValue = true;
        return $this;
    }

    public function match(string|int $input):self
    {
        $this->matchValue = $input;
        return $this;
    }

    public function reset():self
    {
        // Nulify All Values here;

        $properties = get_object_vars($this);

        foreach($properties as $property => $value)
        {       
                $this->{$property} = null;
        }
        return $this;
    }

    public function validate($input)
    {
        if($this->requiredValue !== null && !$this->validteRequired($input))
        {
        
        }

        if($this->matchValue !== null)
        {
            echo "WE will attempt to match";
        }
        return true;
    }


    // --- Private Setters Methods ---- //

    private function validteRequired($input):bool
    {   
        if($this->requiredValue === true && empty($input))
        {   
            return false;
        }
        return true;
    }

    public function validateMatch($input)
    { 
        // validate Both Inputs.
    }
}