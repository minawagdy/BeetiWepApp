<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Libs\Misc;
use Request;

class Cart extends BaseModel {

    protected $guarded = [
    ];
    protected $hidden = [];

    public $table = "cart";

	public function productPrice() {
        return $this->belongsTo('App\Models\ProductPrice', "price_id");
    }
    public function product() {
        return $this->belongsTo('App\Models\Product', "product_id");
    }
}
