<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Libs\Misc;
use Request;

class Gov extends BaseModel
{

    protected $guarded = [
    ];
    protected $hidden = [
    ];
    public $table = "govs";

    public function country(){
   		return  $this->belongsTo('App\Models\Countries','country_id');
 	}

}
