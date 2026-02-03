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
            echo "We Will use SHell";
        }
    }

    private int $mode = 0;
    private array $modes = [0600, 0644, 0664, 0700, 0755, 0777];

    protected function validMode(int $mode)
    {
        if (in_array($mode, $this->modes)) {
            return true;
        } else {
            return false;
        }
    }

    public function writable(string $path)
    {
        return is_writable($path) ? true : false;
    }

    public function readable(string $path)
    {
        return is_readable($path) ? true : false;
    }



    public function hasPermissions($path)
    {
        return $this->linux_fs_interface->getPermissions($path);
    }

    public function setPermissions(string $path, int $permissions = 0755)
    {
        
    }

    public function getFilePerms($filename)
    {
        $perms = stat(fileperms($filename));
        return $perms;
    }
}
