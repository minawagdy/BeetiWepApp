<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Libs\Misc;
use Request;

class City extends BaseModel {

    protected $guarded = [
    ];
    protected $hidden = [
    ];
    public $table = "cities";

    public function gov(){
   		return  $this->belongsTo('App\Models\Gov','gov_id');
 	}

}
