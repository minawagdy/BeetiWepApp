<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Libs\Misc;
use Request;


class BankAccount extends BaseModel
{
    protected $guarded = [
    ];
    protected $hidden = [];

    public $table = "bank_accounts";

    public function country() {
        return $this->belongsTo("\App\Models\Countries",'country_id');
    }

    public function getLogoAttribute($value)
    {
        return env('APP_URL') . "/storage/bank_logo/" . $value;
    }
}


