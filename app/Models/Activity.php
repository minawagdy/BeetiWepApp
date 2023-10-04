<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Libs\Misc;
use Request;

class Activity extends BaseModel {

    protected $guarded = [
    ];
    protected $hidden = [
    ];
    public $table = "activity_log";

    public function admin(){
        return  $this->belongsTo('App\Models\Admin','causer_id');
    }

    public function provider(){
        return  $this->belongsTo('App\Models\Provider','causer_id');
    }
    public function product(){
        return  $this->belongsTo('App\Models\Product','subject_id');
    }
    public function causer(){
        if($this->causer_type == "App\Models\Admin"){
          return  $this->admin->name;
            }else if($this->causer_type == "App\Models\Provider"){
                return    $this->provider->name;
            }
    }

    public function subject(){
        if($this->subject_type == "App\Models\Product"){
          return  $this->product->title;
            }else if($this->subject_type == "App\Models\Provider"){
                return  $this->belongsTo('App\Models\Provider','subject_id');
            }
    }

    public function getDescriptionAttribute($value) {

		if($this->subject_type == "App\Models\Product"){
			return 'New Product  '. $value .' by '.  $this->causer() ;
		}elseif($this->subject_type ==  "App\Models\Provider"){
			return  $this->subject->name . ' Provider  '. $value .' by ' . $this->causer();
		}else{
		        return $value;
        }
	}
}
