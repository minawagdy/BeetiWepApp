<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class CustomerNotification extends Model
{
  public $table = "customer_notifications";
  protected $guarded = [
  ];
  public function customer(){
   return  $this->belongsTo('App\Models\Customer','customer_id');
  }
    public function getCreatedAtAttribute($date) {
        return Carbon::parse($date)->addHour(2)->format('F j, Y @ g:i A');
    }

    public function getUpdatedAtAttribute($date) {
        return Carbon::parse($date)->addHour(2)->format('F j, Y @ g:i A');
    }
}
