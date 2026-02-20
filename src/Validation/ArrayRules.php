<?php
namespace LazarusPhp\Foundation\Validation;

use LazarusPhp\Foundation\ErrorHandler\Errors;
use LazarusPhp\Foundation\Validation\Traits\ErrorTrait;

final class ArrayRules
{

    use ErrorTrait;
    private Errors $errors;


// ---- Properties ---- //


    // Keys and values for Storing
    private array|string|int|null $keys = null;
    private array|string|int|null $values = null;

    // Invalid Keys and Values
    private array $invalidKeys = [];
    private array $invalidValues = [];



    // ---- constructor --- /

    private function __construct($errors)
    {
        $this->errors = $errors;
        $this->reset();
    }


    // ---- Static Method  Entry Points ---- //

    
     /**
      *  public method used as an entry point.
      *  @method create()
      * @return self
      */

    public static function create(?Errors $errors = null): self
    {
        $errors = $errors ?? new Errors();
        return new self($errors);
    }




        public function hasKeys(array|string|int $keys):self
    {
        if($this->keys !== null){
            $this->errors->add("config","method ".__FUNCTION__. " has Already been Set");
        }
        else{
            $this->keys = $keys;
        }            
        return $this;
    }


    public function hasValues(array|string|int $values):self
    {

      if($this->values !== null){
            $this->errors->add("config","method ".__FUNCTION__. " has already been Set");
        }
     else{
            $this->values = $values;
        }            
        return $this;
    }


    /**
     * @public @method Validate
     * @return bool
     * Method used for validating Chain
     */
    public function validate(array $value):bool
    {

        $this->clearErrors();
        if($this->values !== null  && !$this->validateValues($this->values,$value))
        {
            $this->errors->add("logic","Invalid values: " . implode(", ", $this->invalidValues));
        }

        if($this->keys !== null  && !$this->validateKeys($this->keys,$value))
        {
            $this->errors->add("logic",implode(", ",$this->invalidKeys)." are not part of the valid Key selection");
        }

        return $this->isValid();
        
    }


    
    // ---- Private Methods ---- //
    private function validateKeys(array|string|int $keys, array $array):bool
    {
        
         $this->invalidKeys = [];
        if(is_array($keys))
        {
            foreach($keys as $key)
            {
                if(!array_key_exists($key,$array)){
                    $this->invalidKeys[] = $key;
                }
            }
            
        return empty($this->invalidKeys);
        }

        if(!array_key_exists($keys,$array))
        {
            $this->invalidKeys[] = $keys;
            return false;
        }

        return true;
    }

    private function validateValues(array|string|int $values, array $array):bool
    {
        $this->invalidValues = [];
        if(is_array($values))
        {
            foreach($values as $value)
            {
                if(in_array($value,$array,true) === false)
                {
                    $this->invalidValues[] = $value;
                }
            }

        return empty($this->invalidValues);
        }


        if(in_array($values,$array,true) === false)
        {
            $this->invalidValues[] = $values;
            return false;
        }

        return true;
    }

    /**
     * @method reset
     * @return self
     * @property
     */
    public function reset():self
    {
        $this->invalidKeys = [];
        $this->invalidValues = [];
        $this->keys = null;
        $this->values = null;
        return $this;
    }




}