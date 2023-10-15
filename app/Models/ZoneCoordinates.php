<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Request;
class ZoneCoordinates extends BaseModel
{
    protected $guarded = [
    ];
    protected $hidden = [
    ];
    protected $fillable = [
        'zone_id',
        'lat',
        'lng',
    ];
    public $table = "zone_coordinates";

    public function zone()
    {
        return $this->belongsTo(Zones::class,'zone_id');
    }

}
