<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Libs\Misc;
use Request;

class CustomerToken extends BaseModel {

    protected $guarded = [
    ];
    protected $hidden = [
    ];
    public $table = 'customer_tokens';
    public function customer() {
        return $this->belongsTo('App\Models\Customer','customer_id');
    }

}
