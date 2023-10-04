<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Libs\Misc;
use Request;

class PromoUse extends BaseModel {

    protected $guarded = [
    ];
    protected $hidden = [];

    public $table = "promocode_uses";

}
