<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Libs\Misc;
use Request;

class Countries extends BaseModel
{


    protected $fillable = [
        'iso',
        'name',
        'nicename',
        'iso3',
        'numcode',
        'phonecode',
        'offset',
        'bank_account','fees_percentage','lowest_value','wallet_limit','iban','bank_name','is_active','bank_name_ar'
    ];
    protected $hidden = ['updated_at','created_at'];
    public function currency()
    {
        return $this->hasOne(Currency::class,"country_id");
    }

    public function payment() {
        return $this->BelongsToMany('App\Models\CountriesPaymentMethods', 'countries_payment_methods', 'country_id', 'payment_method_id');
    }

    public static function boot() {
        parent::boot();

        static::deleting(function($country) {
             $country->currency()->delete();



        });
    }


    public function category() {
        return $this->belongsToMany(Category::class,'category_countries','country_id','category_id');
    }
}
