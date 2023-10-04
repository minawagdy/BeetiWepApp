<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Libs\Misc;
use Request;
class ProviderStatus extends BaseModel
{
    
    protected $guarded = [
    ];
    protected $hidden = [];

    public $table = "provider_status";

    
    public function provider()
    {
         return $this->hasMany(Provider::class);
       
    }


    public static function boot() {
        parent::boot();

        static::deleting(function($provider) { 
             $provider->categories()->delete();
            
             
        });
    }
}
