<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends BaseModel {

    protected $guarded = [
        //  'slug',
    ];

    public function createdby() {
        return $this->belongsTo('App\Models\Admin','created_by');
    }
    public function updatedby() {
        return $this->belongsTo('App\Models\Admin','updated_by');
    }
    public function permissions() {
        return $this->belongsToMany('App\Models\Permission', 'group_permissions', 'role_id', 'permission_id')
                              ->select(['category'])->distinct();
    }
}
