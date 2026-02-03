<?php
namespace LazarusPhp\Foundation\PathResolver;

use LazarusPhp\Foundation\PathResolver\Enums\Paths;
use LogicException;

final class Resolve
{
    private static array $map = [];
    public static string $root;
    private static bool $initialized = false;

    private static array $restricted = ["vendor"];

    public static function init($basedir,$levels = 1)
    {
        self::$root = dirname($basedir,$levels);

        self::$map = [
            "Root"=>self::$root,
            "App"=>self::$root.DIRECTORY_SEPARATOR."App",
            "Routes"=>self::$root.DIRECTORY_SEPARATOR."Routes",
            "Storage"=>self::$root.DIRECTORY_SEPARATOR."Storage",
            "Config"=>self::$root.DIRECTORY_SEPARATOR."Config",
        ];

        self::$initialized = true;
    }

    private static function getRestrictedPaths($path)
    {
        foreach(self::$restricted as $restricted)
        {
            if(str_starts_with($path,self::$root.DIRECTORY_SEPARATOR.$restricted))
            {
                throw new LogicException("Path : $path is Restricted and cannot be used");   
            }
        }
    }

    public static function remove(string $key)
    {
        $key = strtolower($key);
        foreach(Paths::cases() as $case)
        {
            if($case->value === $key)
            {
                throw new LogicException("Cannot Remove Reserved Paths");
            }
        }
        // Check if the key Exists and Delete
        if(isset(self::$map[$key]))
        {
            unset(self::$map[$key]);
        }
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
        self::getRestrictedPaths($path);      
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