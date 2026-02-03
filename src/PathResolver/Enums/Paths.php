<?php
namespace LazarusPhp\Foundation\PathResolver\Enums;

enum Paths:string
{
    case Root = "Root";
    case App = "App";
    case Routes = "Routes";
    case Config = "Config";
    case Storage = "Storage";

    
    public function label()
    {
        return (string) $this->name;
    }
}
