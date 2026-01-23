<?php
namespace LazarusPhp\Foundation\Mapper;

use LazarusPhp\Foundation\Enums\PathRegistry;

class Paths
{

    private static string $basename = "";
    private static array $paths = [];
    
    public static function setPath($path,string $basename=""):void
    {
        $basename = empty($basename) ? __DIR__."/../../../" : $basename;
   
        echo realpath($basename).$path;

    }

    public static function getPath(PathRegistry $path):void
    {

    }
}