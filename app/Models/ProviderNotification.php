<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProviderNotification extends Model
{
  public $table = "provider_notifications";
  protected $guarded = [
  ];
  public function provider(){
   return  $this->belongsTo('App\Models\Provider','provider_id');
  }

}
