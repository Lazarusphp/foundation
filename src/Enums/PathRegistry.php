<?php
namespace LazarusPhp\Foundation\Enums;

use LazarusPhp\Foundation\Mapper\Paths;

enum PathRegistry
{
      case Root;
      case App;
      case Config;
      case Storage;
      case Public;
      case Routes;
      case Resources;

    public function relative()
    {
        return match($this)
        {
            self::Root => "/../",
            self::App =>  $this->relative()."/App",
            self::Config => $this->relative()."/Config",
            self::Storage => $this->relative()."/Storage",
        };
    }

}