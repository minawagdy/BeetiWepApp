<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Libs\Misc;
use Request;

class ProviderAd extends BaseModel {
    protected $append=['title_field','des_field'];

    protected $guarded = [
    ];
    protected $hidden = [
    ];
    public $table = "provider_ads";

	public function getImageAttribute($value) {
		return 	asset("/storage/Ads_images/".$value);
	}
	public function getTitleFieldAttribute() {
        if(app()->getLocale()=='ar'){
            return $this->title_ar;
        }else{
            return $this->title;
        }

	}
	public function getDesFieldAttribute() {
        if(app()->getLocale()=='ar'){
            return $this->description_ar;
        }else{
            return $this->description;
        }

	}

	public function provider() {
        return $this->belongsTo('\App\Models\Provider',"provider_id");
    }

}
