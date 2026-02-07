<?php
namespace LazarusPhp\Foundation\Validation;

use LogicException;

final class ArrayRules
{



// ---- Properties ---- //


    // Keys and values for Storing
    private array|string|int|null $keys = null;
    private array|string|int|null $values = null;

    // Invalid Keys and Values
    private array $invalidKeys = [];
    private array $invalidValues = [];


    // ---- constructor --- /

    public function __construct()
    {
        $this->reset();
    }


    // ---- Static Method  Entry Points ---- //

    
     /**
      *  public method used as an entry point.
      *  @method create()
      *  @static
      *  @return self
      */

    public static function create():self
    {
        return new self();
    }


    // ---- Public Methods ---- //

    private function isArray($array):bool
    {
        return is_array($array);
    }


        public function hasKeys(array|string|int $keys,?array $array=null)
    {
        if($array !== null)
        {
            return $this->validateKeys($keys,$array);
        }

        if($this->keys !== null){
            throw new LogicException("Key has already been Set");
        }

            $this->keys = $keys;
            return $this;
    }


    public function hasValues(array|string|int $values, ?array $array=null)
    {
        if($array !== null)
        {
            return $this->validateValues($values,$array);
        }

        if($this->values !== null)
        {
            throw new LogicException(" Has Values Method  has already been set");
        }

        $this->values = $values;
        return $this;
    }


    /**
     * @public @method Validate
     * @return bool
     * Method used for validating Chain
     */
    public function validate(array $value):bool
    {
        if(!$this->isArray($value))
        {
            throw new LogicException("Validation Failed : Value Must be an array" .gettype($value)." Used");
        }

        if($this->values !== null  && !$this->validateValues($this->values,$value))
        {
            throw new LogicException("Values :  ". implode(", ",$this->invalidValues) . " is not part of the selected Array");
        }

        if($this->keys !== null  && !$this->validateKeys($this->keys,$value))
        {
            throw new LogicException("Key or keys : ".implode(", ",$this->invalidKeys)." is not part of the selected Array");
        }
        return true;
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

    private function validateValues(array|string|int $values, array $array)
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