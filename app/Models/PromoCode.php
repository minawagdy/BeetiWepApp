<?php

namespace App\Models;

use Request;
use App\Libs\Misc;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class PromoCode extends BaseModel {

    protected $guarded = [
    ];
    protected $hidden = [
    ];
    public $table = "promo_codes";


    public function getExpiryDateAttribute($date)
    {

        $temp = Carbon::parse($date);
        return $temp->toDayDateTimeString();
    }
}

