<?php
namespace LazarusPhp\Foundation\Application\Interfaces;
use LazarusPhp\Foundation\Application\Container;

interface ProviderInterface
{
    public function register(Container $c): void;
}