<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Libs\Misc;
use Request;

class CustomerProviderChat extends BaseModel {

    protected $guarded = [
    ];
    protected $hidden = [
    ];
    public $table = "customers_providers_chat";

    public function customer(){
   		return  $this->belongsTo('App\Models\Customer','customer_id');
 	}

    public function provider(){
        return  $this->belongsTo('App\Models\Provider','provider_id');
    }

    public function messages(){
        return $this->hasMany('App\Models\CustomerProviderChatMessages','chat_id');
    }

}
