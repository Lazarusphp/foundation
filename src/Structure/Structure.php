<?php
namespace LazarusPhp\Foundation;

final class Structure
{

    /**
     * @method isFile
     * Detect if is a file
     * @property string $path;
     * @return bool 
     */
    public function isFile(string $path)
    {
        return (bool) (is_file($path)) ? true : false;
    }

    
    /**
     * @method isFile
     * Detect if is a file
     * @property string $path;
     * @return bool 
     */
    public function hasFile(string $path)
    {
        return (bool) (file_exists($path)) ? true : false;
    }

    /**
     * @method hasDirectory
     * @property string $path
     * @return bool
     * Helper function to detect if a directory exists.
     */
    public function hasDirectory(string $path):bool
    {
        return (bool) is_dir($path) ? true : false;
    }

}