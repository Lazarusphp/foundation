<?php
namespace LazarusPhp\Foundation\FileSystem;

use LazarusPhp\Exceptions\Exceptions\DirectoryNotFoundException;
use LazarusPhp\Foundation\Permissions\Permissions;
use LogicException;

final class FileSystem
{

    public function __construct()
    {
        // return new static();
    }
    /**
     * @method isFile
     * Detect if is a file
     * @property string $path;
     * @return bool 
     */


    public static function isFile(string $path):bool
    {
        return (bool) (is_file($path)) ? true : false;
    }

    /**
     * @method createDirectory
     * Create a new directory
     * @property string $path
     * @property int $permissions
     * @return bool
     */
    public static function makeDirectory(string $path, int $permissions = 0755,$recursive=true):bool
    {
        echo $permissions;
        // Validate Permissions Mode here Required Permissions CLass

    
        
        if(self::hasDirectory($path))
        {
            return true;
        }

        if(Permissions::validMode($permissions) === false)
        {
            throw new LogicException("Permission $permissions is invalid");
            return false;
        }

        return mkdir($path, $permissions, $recursive);
        
      
    }

    /**
     * @method deleteFile
     * Delete a file
     * @property string $path
     * @return bool
     */
    public static function deleteFile(string $path):bool
    {
        return self::isFile($path) ? unlink($path) : false;
    }

    /**
     * @method deleteDirectory
     * Delete a directory recursively
     * @property string $path
     * @return bool
     */
    public static function deleteDirectory(string $path):bool
    {
        if (!is_dir($path)) return false;
        foreach (scandir($path) as $item) {
            if ($item === '.' || $item === '..') continue;
            $itemPath = $path . DIRECTORY_SEPARATOR . $item;
            is_dir($itemPath) ? self::deleteDirectory($itemPath) : unlink($itemPath);
        }
        return rmdir($path);
    }

    /**
     * @method readFile
     * Read file contents
     * @property string $path
     * @return string
     */
    public static function readFile(string $path):string
    {
        return self::isFile($path) ? file_get_contents($path) : '';
    }

    /**
     * @method writeFile
     * Write content to file
     * @property string $path
     * @property string $content
     * @return bool
     */
    public static function writeFile(string $path, string $content):bool
    {
        return file_put_contents($path, $content) !== false;
    }
    /**
     * @method isFile
     * Detect if is a file
     * @property string $path;
     * @return bool 
     */
    public static function hasFile(string $path):bool
    {  
        if(self::hasDirectory(dirname($path))){
            return (bool) (file_exists($path)) ? true : false;
        }
        else
        {
            throw new LogicException("Path Not Found Logic Failed");
            return false;
        }
    }

    /**
     * @method hasDirectory
     * @property string $path
     * @return bool
     * Helper function to detect if a directory exists.
     */
    public static function hasDirectory(string $path):bool
    {
        return (bool) is_dir($path) ? true : false;
    }

}