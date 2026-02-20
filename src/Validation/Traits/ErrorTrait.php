<?php
namespace LazarusPhp\Foundation\Validation\Traits;

trait ErrorTrait
{

    public function error(string $key)
    {
        return $this->errors->get($key);
    }

    public function errors():array
    {
        return $this->errors->all();
    }

    private function isValid()
    {
        return $this->errors->count() === 0;
    }

    private function clearErrors():null
    {
        return $this->errors->reset();
    }
}