<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderReviews extends BaseModel
{
    use HasFactory;

    protected $guarded = [
    ];
    protected $hidden = [
    ];
    public $table = "order_reviews";

    public function order() {
        return $this->belongsTo(Order::class,'order_id');
    }
    public function order2() {
        return $this->hasMany(Order::class,'id');
    }
}
