<?php
namespace LazarusPhp\Foundation\Providers\Psr;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use InvalidArgumentException;

class Container implements ContainerInterface
{

    protected array $instances = [];
    protected array $bindings = [];
    private array $flags = [];

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

    public function has(string $id):bool
    {
        return isset($this->bindings[$id]);
    }

    public function get(string $id)
    {
          if (!$this->has($id)) {
        throw new class(
            "Service [$id] is not bound in the container."
        ) extends InvalidArgumentException
          implements NotFoundExceptionInterface {};
    }
        return $this->bindings[$id]($this);
    }
}