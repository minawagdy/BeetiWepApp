<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Libs\Misc;
use Request;

class AdminToken extends BaseModel {

    protected $guarded = [
    ];
    protected $hidden = [
    ];
    public $table = 'admin_tokens';
    public function admin() {
        return $this->belongsTo('App\Models\Admin','admin_id');
    }

}
