<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Libs\Misc;
use Request;

class Cron extends BaseModel {
  public static function boot() {
          parent::boot();
          static::deleted(function($row) {

              $images = $row->images()->get();
              if ($images) {
                  foreach ($images as $img) {
                      Misc::deleteImage(@$img->image_name);
                  }
              }
              $row->images()->delete();
          });
      }
    protected $guarded = [
    ];
    protected $hidden = [
    ];
    protected $table = 'crons';

    public function images() {
            return $this->morphMany('App\Models\Image', 'imageable');
        }
}
