<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends BaseModel
{
    use HasFactory;

    protected $guarded = [
        'reset_token',
        'remember_token',
        'token',
        'password_confirmation',
    ];
    protected $hidden = ['password', 'remember_token',
        'reset_token', 'remember_token', 'token', 'updated_at','pivot'];

    public $table = "drivers";


    public function setPasswordAttribute($value) {
        $this->attributes['password'] = bcrypt($value);
    }
    public function getNationalIdImgFrontAttribute($value) {
        if ($value != null) {
            return env('APP_URL') . "/storage/driver_images/" . $value;
        }
    }
    public function getNationalIdImgBackAttribute($value) {
        if ($value != null) {
            return env('APP_URL') . "/storage/driver_images/" . $value;
        }
    }
    public function getProfileImgAttribute($value) {
        if ($value != null) {
            return env('APP_URL') . "/storage/profile_images/" . $value;
        }
    }

    public function orders() {
        return $this->BelongsToMany('App\Models\DriverOrders', 'driver_orders', 'driver_id', 'order_id');
    }

    public function providers() {
    //    return $this->BelongsToMany('App\Models\ProviderDriver', 'provider_driver', 'driver_id', 'provider_id');
    return $this->belongsToMany(Provider::class,'provider_driver');
    }
    public function statusObj()
    {
         return $this->belongsTo(DriverStatus::class,'status');

    }

    public function zone()
    {
         return $this->belongsTo(Zones::class,'zone_id');

    }
    public function countryObj()
    {
        return $this->belongsTo("\App\Models\Countries","country");
    }
    public function zoneObj()
    {
        return $this->belongsTo("\App\Models\Zones","zone_id");
    }
    public function govObj()
    {
        return $this->belongsTo("\App\Models\Gov","gov");
    }
    public function CustomerReview()
    {
        return $this->hasMany(DriverCustomerReviews::class);

    }
    public function ProviderReview()
    {
        return $this->hasMany(DriverProviderReviews::class);

    }
    public function images() {
        return $this->morphMany('App\Models\Image', 'imageable');
    }
}
