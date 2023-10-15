<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Libs\Misc;
use Request;

class OrderProduct extends BaseModel {

    protected $guarded = [
    ];
    protected $hidden = [];

    public $table = "order_products";


    public function price() {
        return $this->belongsTo('App\Models\ProductPrice',"price_id");
    }

    public function product() {
        return $this->belongsTo('App\Models\Product',"product_id");
    }
    public function order() {
        return $this->hasMany(Order::class,'id');
    }
    public function order2() {
        return $this->belongsTo(Order::class,'order_id');
    }
}
