<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Libs\Misc;
use Request;

class PaymentMethod extends BaseModel {

    protected $guarded = [
    ];
    protected $hidden = ['pivot'];

    public $table = "payment_methods";

    public function getIconAttribute($value)
    {
        if ($value != null) {
            return env('APP_URL') . "/storage/icons/" . $value;
        }
    }


    public function getTitleAttribute($value) {
		if(Request::header('lang') == "en"){
            return $value;
        }else if(Request::header('lang') == "ar"){
            return $this->title_ar;
        }else{
            return $value;
        }
	}
    public function countries() {
    return $this->hasMany(CountriesPaymentMethods::class,'payment_method_id');
    }

//    public function getTitleAttribute($value) {
//		if(Request::header('lang') == "en"){
//            return $value;
//        }else{
//            return $this->title_ar;
//        }
//	}

    public static function boot() {
        parent::boot();

        static::deleting(function($country) {
            $country->countries()->delete();



        });
    }
}
