<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Request;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable {

    protected $table = "admins";
    //////


    protected $guard = 'admin';

    protected $guarded = [

        'heades',
        'selectAll',
        'reset_token',
        'password_confirmation',
        'super_admin',
        'old_password',
        'deleted_at',
        'role_list'
    ];
    protected $hidden = ['password', 'reset_token', 'deleted_at'];

    public static function boot() {
        parent::boot();
        static::deleted(function($row) {
            $row->roles()->detach();
        });
    }

    public function setPasswordAttribute($value) {
        $this->attributes['password'] = bcrypt($value);
    }

    public function roles() {
        return $this->BelongsToMany('App\Models\Role', 'admin_role', 'admin_id', 'role_id');
    }

    public function getRoleListAttribute() {
        return $this->roles->pluck('id')->toArray();
    }

    public function job() {
        return $this->belongsTo('App\Models\Role','role_id');
    }

    public function getProfileImgAttribute($data)
    {
        if ($data!= null)
        {
            return env('APP_URL')."/storage/admin_images/".$data;
        }
        else
        {
            return  $data;
        }
    }
}
