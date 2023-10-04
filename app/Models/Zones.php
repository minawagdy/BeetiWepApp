<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Request;
class Zones extends BaseModel
{
    protected $guarded = [
    ];
    protected $hidden = [
    ];
    protected $fillable = [
        'code',
        'name',
        'description',
        'status'
    ];
    public $table = "zones";

    public function coordinate()
    {
        return $this->hasMany(ZoneCoordinates::class);
    }

    public function country()
    {
        return $this->belongsTo("\App\Models\Countries","country_id");
    }
    public function gov()
    {
        return $this->belongsTo("\App\Models\Gov","gov_id");
    }



    public static function boot() {
        parent::boot();

        static::deleting(function($zone) {
             $zone->coordinate()->delete();



        });
    }
}
