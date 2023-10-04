<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverNotification extends Model
{

    public $table = "driver_notifications";
    protected $guarded = [
    ];
    public function driver(){
        return  $this->belongsTo('App\Models\Driver','driver_id');
    }
    public function getCreatedAtAttribute($date) {
        return Carbon::parse($date)->addHour(2)->format('F j, Y @ g:i A');
    }

    public function getUpdatedAtAttribute($date) {
        return Carbon::parse($date)->addHour(2)->format('F j, Y @ g:i A');
    }
}
