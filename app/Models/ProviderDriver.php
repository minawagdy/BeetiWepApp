<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Libs\Misc;
use Request;

class ProviderDriver extends BaseModel
{
    protected $guarded = [
    ];
    protected $hidden = [
    ];
    public $table = "provider_driver";

    // public function drivers() {
    //     return $this->belongsToMany(Driver::class,'driver_id');
    // }
    // public function provider() {
    //     return $this->belongsTo(Provider::class,'provider_id');
    // }
}
