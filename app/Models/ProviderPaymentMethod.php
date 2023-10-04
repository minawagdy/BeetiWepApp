<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Libs\Misc;
use Request;

class ProviderPaymentMethod extends BaseModel {

    protected $guarded = [
    ];
    protected $hidden = [
    ];
    public $table = "provider_payment_methods";

}
