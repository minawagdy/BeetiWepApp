<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Libs\Misc;
use Request;

class CustomerProviderChatMessage extends BaseModel {

    protected $guarded = [
    ];
    protected $hidden = [
    ];
    public $table = "customers_providers_chat_messages";

    public function getImageAttribute($value) {
		return 	env('APP_URL')."/storage/chat_images/".$value;
	}

}
