<?php
namespace LazarusPhp\Foundation\Permissions;

use LazarusPhp\Foundation\Permissions\Interfaces\LinuxFsInterface;
use LogicException;

final class Posix implements LinuxFsInterface
{
    protected $username;
    protected $groups;
    protected array $modes = 
    [
        '0755' => 0755,
        '0644' => 0644,
        '0777' => 0777,
        '0700' => 0700,
        '0600' => 0600,
        '0775' => 0775,
        '0664' => 0664,
    ];

    public function hasUsername(?string $username="")
    {
        $username = empty($username) ? env("www_username") : $username;
        $username = posix_getpwnam($username);

        if($username === false)
        {
            throw new LogicException("Username NOt Found");
            return false;
        } 
        $this->username = $username;
        return true;
        
    }

        public function hasGroup(string $group=""):bool
    {
        $username = $this->username;
        $group = (empty($group)) ? env("www_group") : $group;
        
        // Check in Primary
        if($this->hasGroup($this->username,$group) === true ||
        $this->allGroups($this->username,$group) === true)
        {
            return true;
        }
        return false;
    }

    public function getPermissions(string $path): string
    {
        $perms = fileperms($path);

        $info = ($perms & 0x4000) ? 'd' : '-';

    $info .= ($perms & 0x0100) ? 'r' : '-';
    $info .= ($perms & 0x0080) ? 'w' : '-';
    $info .= ($perms & 0x0040) ? 'x' : '-';

    $info .= ($perms & 0x0020) ? 'r' : '-';
    $info .= ($perms & 0x0010) ? 'w' : '-';
    $info .= ($perms & 0x0008) ? 'x' : '-';

    $info .= ($perms & 0x0004) ? 'r' : '-';
    $info .= ($perms & 0x0002) ? 'w' : '-';
    $info .= ($perms & 0x0001) ? 'x' : '-';

    return $info;
    }

    public function getOwner(string $path):string
    {
        return fileowner($path);
    }

    public function getGroupOwner(string $path)
    {
        return filegroup($path);
    }

    public function setPermissions(string $path, $permissions)
    {if (is_dir($path)) {
            // Convert to String
            if(in_array($permissions,$this->modes)){

                if(!chmod($path,$permissions))
                {
                    throw new LogicException("Permission ReWrite Failed");
                }
               
            }
            else
            {
                throw new LogicException("Permission Value : $permissions is not valid");
            }
        }

        if (is_file($path) && file_exists($path)) {
            if (!chmod($path, $permissions)) {
                echo "failed";
            }
        }
    }

    // Private Methods

    private function findGroups(array $username,string $group)
    {
        $primaryGroup = posix_getgrgid($username["gid"]);
        if($primaryGroup && $primaryGroup["name"] === $group)
        {
            return true;
        }
    }

    private function allGroups(array $username,string $group)
    {
        $groups = posix_getgroups();
        echo $username["name"];
       foreach ($groups as $gid) {
        $g = posix_getgrgid($gid);
        if ($g &&
            in_array($username["name"], $g['members'], true) &&
            $g['name'] === $group
        ) {
            return true;
        }
       }
    }


}
?>