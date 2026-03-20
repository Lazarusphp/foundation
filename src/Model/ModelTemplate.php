<?php
namespace App\Http\Model;
use LazarusPhp\QueryBuilder\Traits\Relationships;
use App\Http\Model\Posts;
use LazarusPhp\Foundation\Model\Model;

class ModelTemplate extends Model
{
    // Store all “real” methods in an internal array

    protected $allowed = [];
    protected string $primaryKey = "id";
    protected string $table = "";
    protected string $model = "";

    // Require Relations Trait
    use Relationships;

    public function posts()
    {
        return $this->hasMany(Posts::class,"id","uid");
    }

    public function comments()
    {
        return $this->hasMany(Comments::class,"id","uid");
    }

    public function profile()
    {
        return $this->hasOne(Profile::class,"id","uid");
    }

    public function Roles()
    {
        return $this->belongsToMany(Roles::class,"id","role_id");
    }
    

}