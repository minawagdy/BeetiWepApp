<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Libs\Misc;
use Request;

class Category extends BaseModel {

    protected $guarded = [
    ];
    protected $hidden = ['pivot'];

    public $table = "categories";

    public function getLogoAttribute($value) {
		return 	env('APP_URL')."/storage/categories_images/".$value;
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
        return $this->belongsToMany(Countries::class,'category_countries','category_id','country_id');
    }
    public function products() {
            return $this->hasMany(Product::class);
        }
}
