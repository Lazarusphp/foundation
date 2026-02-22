<?php
namespace LazarusPhp\Foundation\Application;

use App\System\Core\BootLoader;
use Exception;
use LazarusPhp\Foundation\Application\Container;
use LazarusPhp\Foundation\Application\Interfaces\ProviderInterface;

class Providers
{

    private array $providers = [];
    private array $flags = [];

    private function __construct(array $providers)
    {
    
        $this->flags["map"] = true;
        $this->providers = $providers;
    }

    public static function map(array $classes):self
    {
        return new self($classes);
    }


    public function create()
    {

        if(array_key_exists("map",$this->flags) && $this->flags["map"] !== true)
        {
            throw new Exception("Providers::map() must be called before create()");
        }

        $container = new Container();
    // Reset the flags
        $this->flags = [];
        foreach($this->providers as $providerClass)
        {
            if(!class_exists($providerClass))
            {
                throw new Exception("Provider {$providerClass}  does not exists");
            }

            $provider = new $providerClass();

            if(!$provider instanceof ProviderInterface)
            {
                throw new Exception("Provider Class must implement ProviderInterface");
            }

            $provider->register($container);
            // Return something here

            return $container;
        }
    }

 
}