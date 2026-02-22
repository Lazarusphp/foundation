<?php
namespace LazarusPhp\Foundation\Application;

use App\System\Core\BootLoader;
use Exception;

class Container
{

    protected array $instances = [];
    protected array $bindings = [];

    public function bind(string $id,callable $factory):void
    {
        $this->bindings[$id] = $factory;
    }

    public function singleton(string $id, callable $factory):void
    {
        $this->bindings[$id] = function() use ($factory,$id)
        {
            return $this->instances[$id] ??= $factory($this);
        };
    }

    public function get($id)
    {
        return $this->bindings[$id]($this);
    }
}