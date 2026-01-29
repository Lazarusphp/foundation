<?php
namespace LazarusPhp\Foundation;

use LazarusPhp\Foundation\Enums\Paths;
use LogicException;

class PathResolver
{
    private static array $map = [];
    public static string $root;
    private static bool $initialized = false;

    public static function init($basedir,$levels = 1)
    {
        self::$root = dirname($basedir,$levels);

        self::$map = [
            "App"=>self::$root.DIRECTORY_SEPARATOR."App",
            "Routes"=>self::$root.DIRECTORY_SEPARATOR."Routes",
            "Storage"=>self::$root.DIRECTORY_SEPARATOR."Storage",
        ];

        self::$initialized = true;
    }


    
    public static function get(Paths | string $key)
    {
    // Validate if Key is part of the Paths Enum;
         $key = $key instanceof Paths ? $key->value : $key;

        //  check if the key exists

        if (!isset(self::$map[$key])) {
            throw new \InvalidArgumentException("Unknown path: {$key}");
        }
         return self::$map[$key];
    }


    public static function add(string $name,string $path)
    {
       self::isInitialized();
       self::isReserverved($name);
    
       self::$map[$name] = self::resolve($path);
    }

    private static function resolve(string $path)
    {
        if(str_starts_with($path,DIRECTORY_SEPARATOR))
        {
            return rtrim($path, DIRECTORY_SEPARATOR);
        }
        else
        {
            return self::$root.DIRECTORY_SEPARATOR.trim($path, DIRECTORY_SEPARATOR);}
    }


    private static function isInitialized()
    {
        if(!self::$initialized)
        {
            throw new \LogicException("PathResolver is not initialized. Call init method first");
        }
    }

    private static function isReserverved(string $name)
    {
        foreach(Paths::cases() as $case)
        {
            if($case->value === $name)
            {
                throw new LogicException("Cannot OverRide Reservered Names");
            }
        }
    }



}