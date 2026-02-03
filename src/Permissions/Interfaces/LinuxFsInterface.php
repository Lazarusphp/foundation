<?php
namespace LazarusPhp\Foundation\Permissions\Interfaces;

interface LinuxFsInterface
{

    public function hasUsername(string $usernane="");
    public function hasGroup(string $group=""):bool;

    public function getOwner(string $path):string;
    public function getGroupOwner(string $path);
    public function getPermissions(string $path):string;
    public function setPermissions(string $path, $mode);



}