<?php

namespace LazarusPhp\Foundation\Permissions;
use LazarusPhp\Foundation\Permissions\Posix;
use LazarusPhp\Foundation\Permissions\Interfaces\LinuxFsInterface;
use LogicException;

class Permissions
{

    private LinuxFsInterface $linux_fs_interface;

    public function __construct()
    {
        if(extension_loaded('posix'))
        {
            $this->linux_fs_interface = new Posix();
        }
        else
        {
        // Setup to use Shell Exec
        }
    }

    private int $mode = 0;
    private static array $modes = [0600, 0644, 0664, 0700, 0755, 0777];

    public static function validMode(int $mode)
    {
        if (in_array($mode, self::$modes)) {
            return true;
        } else {
            return false;
        }
    }

    public static function writable(string $path)
    {
        return is_writable($path) ? true : false;
    }

    public static function readable(string $path)
    {
        return is_readable($path) ? true : false;
    }



    public function hasPermissions($path)
    {
        return $this->linux_fs_interface->getPermissions($path);
    }


}
