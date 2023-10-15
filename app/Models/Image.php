<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Libs\Misc;
use Request;

class Image extends BaseModel {

    protected $guarded = [

    ];

    public static function boot() {
        parent::boot();
        static::deleted(function($row) {
            if ($row->image_name) {
                Misc::deleteImage($row->image_name);
            }
        });
    }

    public function imageable() {
        return $this->morphTo();
    }

	public function getImageNameAttribute($value) {
		if($this->imageable_type == "App\Models\Product"){
			return asset('/storage/product_images/' . $value);
		}elseif($this->imageable_type ==  "App\Models\Provider"){
			return 	env('APP_URL')."/storage/profile_images/".$value;
		}
        elseif($this->imageable_type ==  "App\Models\Driver"){
            return 	env('APP_URL')."/storage/profile_images/".$value;
        }
		return $value;
	}
    public function admin() {
        return $this->belongsTo('App\Models\Admin');
    }
    public function product() {
        return $this->belongsTo('App\Models\Product','imageable_id');
    }
}
