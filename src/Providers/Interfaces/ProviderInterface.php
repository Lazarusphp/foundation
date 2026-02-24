<?php
namespace LazarusPhp\Foundation\Providers\Interfaces;
use LazarusPhp\Foundation\Providers\Psr\Container;

interface ProviderInterface
{
    public function register(Container $c): void;
}