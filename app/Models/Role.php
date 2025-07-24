<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    // protected $primaryKey = 'role_id';
    public $incrementing = false;

    protected $fillable = ['name','slug','details','status', 'menu_details', 'permission_details', 'permission_ids'];

    public function getCreatedAtAttribute($date)
    {
        return date('j M, Y', strtotime($date));
    }

    /**
     * @param $date
     * @return string
     */
    public function getUpdatedAtAttribute($date)
    {
        return date('j M, Y', strtotime($date));
    }

    public function users()
    {

        return $this->belongsToMany(User::class,'users_roles');

    }

    public function userDetails()
    {

        return $this->belongsToMany(UserDetail::class,'users_roles');

    }

    public function permissions()
    {

        return $this->belongsToMany(Permission::class,'roles_permissions');

    }
}
