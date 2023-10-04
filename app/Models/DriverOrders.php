<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverOrders extends BaseModel
{
    protected $guarded = [
    ];
    protected $hidden = [
    ];
    public $table = "driver_orders";

    public function driver() {
        return $this->belongsTo(Driver::class,'driver_id');
    }
    public function order() {
        return $this->belongsTo(Order::class,'order_id');
    }
}
