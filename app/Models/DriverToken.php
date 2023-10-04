<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Libs\Misc;
use Request;

class DriverToken extends BaseModel
{
    protected $fillable = ['token',"driver_id","device_id",'mobile_id'];
    //fghjkl;'
    protected $guarded = [
    ];
    protected $hidden = [
    ];
    public $table = 'driver_tokens';
    public function driver() {
        return $this->belongsTo('App\Models\Driver','driver_id');
    }

}
