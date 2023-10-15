<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Libs\Misc;
use Request;


class BankTransferRequest extends BaseModel
{
    protected $guarded = [
    ];
    protected $hidden = [];

    public $table = "bank_transfer_requests";

    public function orders() {
        return $this->belongsTo(Order::class,'order_id');
    }
}


