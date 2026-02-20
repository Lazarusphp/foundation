<?php
namespace LazarusPhp\Foundation\Validation\Traits;

trait IntegerTraits
{   

    private int|null $minValue = null;
    private int|null $maxValue = null;


     public function min(int $min):self
    {
        if($this->minValue !== null)
        {
            $this->errors->add("logic",__METHOD__. " has already been Set");
        }
        else
        {
            $this->minValue = $min;
        }
        return $this;
    }

    public function max(int $max):self
    {
         if($this->maxValue !== null)
        {
            $this->errors->add("logic",__METHOD__. " has already been Set");
        }
        else
        {
            $this->maxValue = $max;
        }
        return $this;
    }
    
}