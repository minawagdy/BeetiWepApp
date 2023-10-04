<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Libs\Misc;
use Request;

class ProviderToken extends BaseModel {
    protected $fillable = ['token',"provider_id","device_id",'mobile_id'];
    //fghjkl;'
    protected $guarded = [
    ];
    protected $hidden = [
    ];
    public $table = 'provider_tokens';
    public function provider() {
        return $this->belongsTo('App\Models\Provider','provider_id');
    }

}
