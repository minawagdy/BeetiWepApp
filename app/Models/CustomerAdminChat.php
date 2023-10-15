<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Libs\Misc;
use Request;

class CustomerAdminChat extends BaseModel {

    protected $guarded = [
    ];
    protected $hidden = [
    ];
    public $table = "customers_admins_chat";

    public function customer(){
   		return  $this->belongsTo('App\Models\Customer','customer_id');
 	}

    public function admin(){
        return  $this->belongsTo('App\Models\Admin','admin_id');
    }

    public function messages(){
        return $this->hasMany('App\Models\CustomerAdminChatMessages','chat_id');
    }

}
