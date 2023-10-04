<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Libs\Misc;
use Request;

class ProviderAd extends BaseModel {

    protected $guarded = [
    ];
    protected $hidden = [
    ];
    public $table = "provider_ads";

	public function getImageAttribute($value) {
		return 	env('APP_URL')."/storage/Ads_images/".$value;
	}

	public function provider() {
        return $this->belongsTo('\App\Models\Provider',"provider_id");
    }

}
