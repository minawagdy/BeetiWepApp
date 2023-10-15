<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Libs\Misc;
use Request;

class ActionLog extends BaseModel {

    protected $guarded = [
    ];
    protected $hidden = [
    ];
    public $table = "action_logs";

    public function admin(){
        return  $this->belongsTo('App\Models\Admin','admin_id');
    }
}
