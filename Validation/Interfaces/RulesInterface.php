<?php
namespace LazarusPhp\Foundation\Validation\Interfaces;

interface RulesInterface
{
    public static function create(?array $errors = null);
    public function reset();
}