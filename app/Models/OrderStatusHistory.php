<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Libs\Misc;
use Request;

class OrderStatusHistory extends BaseModel {

    protected $guarded = [
    ];
    protected $hidden = [];

    public $table = "order_status_history";

}
