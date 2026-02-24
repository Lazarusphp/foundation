<?php
namespace LazarusPhp\Foundation\Providers;

use Exception;
use LazarusPhp\Foundation\Providers\Psr\Container;
use LazarusPhp\Foundation\Providers\Interfaces\ProviderInterface;

class Providers
{

    private array $providers = [];
    private array $flags = [];

    public static function map(array $providers):self
    {
        $instance = new self();
        $instance->flags["map"] = true;
        $instance->providers = $providers;
        return $instance;

    }

    public function create()
    {

    // Validarte if the Map flag has Been instantiated;
        if(array_key_exists("map",$this->flags) && $this->flags["map"] !== true)
        {
            throw new Exception("Providers::map() must be called before create()");
        }

        // Start a new Instance;
        $container = new Container();
    // Reset the flags
        $this->flags = [];

        // Loop through the providers.
        foreach($this->providers as $providerClass)
        {
            
            if(!class_exists($providerClass))
            {
                throw new Exception("Provider {$providerClass}  does not exists");
            }

            $provider = new $providerClass();



            // Validate if the provider implements the Provider interface ruleset
            if(!$provider instanceof ProviderInterface)
            {
                throw new Exception("Provider Class must implement ProviderInterface");
            }

            // Register the provider.
            $provider->register($container);
            
        }

        // return the container;
         return $container;
    }

 
}