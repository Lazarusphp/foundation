<?php
namespace LazarusPhp\Foundation\Application;

class Providers
{

    private array $classes = [];

    private function __construct(array $classes)
    {
        $this->classes = $classes;
    }

    public static function map(array $classes):self
    {
        return new self($classes);
    }

    public function create()
    {
        // Will Come back to this later
    }

 
}