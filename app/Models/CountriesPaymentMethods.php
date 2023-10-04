<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CountriesPaymentMethods extends BaseModel
{
//    use HasFactory;
    protected $guarded = [
    ];
    protected $hidden = [];

    public $table = "countries_payment_methods";

    public function countries() {
        return $this->belongsTo(Countries::class,'country_id');
    }
    public function payment() {
        return $this->belongsTo(PaymentMethod::class,'payment_method_id');
    }


}
