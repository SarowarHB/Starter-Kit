<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug'];

    /**
     * Handle events after all transactions are committed.
     *
     * @var bool
     */
    public $afterCommit = true;

    public function permissions()
    {
        return $this->belongsToMany(Permission::class,'role_permissions');
    }

    public function users()
    {
        return $this->belongsToMany(User::class,'user_roles');
    }

    public function hasPermission($slug)
    {
        return (bool) $this->permissions->where('slug', $slug)->count();
    }
    
    // Custom Functions
    public static function getAll()
    {
        return self::all();
    }

}
