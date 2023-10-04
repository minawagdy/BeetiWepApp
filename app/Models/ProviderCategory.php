<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Libs\Misc;
use Request;

class ProviderCategory extends BaseModel {

    protected $guarded = [
    ];
    protected $hidden = [
    ];
    public $table = "provider_categories";
    public function category() {
        return $this->belongsTo(Category::class,'category_id');
    }
    public function provider() {
        return $this->belongsTo(Provider::class,'provider_id');
    }
}
