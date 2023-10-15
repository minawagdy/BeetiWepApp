<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Libs\Misc;
use Request;

class ProviderAdminChat extends BaseModel {

    protected $guarded = [
    ];
    protected $hidden = [
    ];
    public $table = "providers_admins_chat";

    public function provider(){
   		return  $this->belongsTo('App\Models\Provider','provider_id');
 	}

    public function admin(){
        return  $this->belongsTo('App\Models\Admin','admin_id');
    }

    public function messages(){
        return $this->hasMany('App\Models\ProviderAdminChatMessages','chat_id');
    }

}
