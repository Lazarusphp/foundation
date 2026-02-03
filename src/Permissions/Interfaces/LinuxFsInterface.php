<?php
namespace LazarusPhp\Foundation\Permissions\Interfaces;

interface LinuxFsInterface
{

    public function hasUsername();
    public function hasGroup():bool;

    public function getOwner(string $path):string;
    public function getGroupOwner(string $path);
    public function getPermissions(string $path):string;
    public function setPermissions(string $path, $mode);



}