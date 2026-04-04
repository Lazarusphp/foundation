<?php
namespace LazarusPhp\Core\FileSystem;
use LazarusPhp\Core\FileSystem\Directories;
use LazarusPhp\Core\FileSystem\Files;
use LazarusPhp\Core\FileSystem\PathInfo;
use LogicException;

final class FileSystem
{
    public ?Directories $directories = null;
    public ?Files $files = null;
    public ?Permissions $permissions = null;
    public ?PathInfo $info = null;

    public function __construct()
    {
        $this->directories =  new Directories();
        $this->files = new Files();
        $this->permissions = new Permissions();
        $this->info = new PathInfo();
    }
}