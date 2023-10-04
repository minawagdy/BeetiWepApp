<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminNotification extends Model
{
  public $table = "admin_notifications";
  protected $guarded = [
  ];
  public function admin(){
   return  $this->belongsTo('App\Models\Admin','admin_id');
  }
}
