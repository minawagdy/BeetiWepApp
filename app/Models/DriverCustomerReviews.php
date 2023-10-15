<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverCustomerReviews extends BaseModel
{
    use HasFactory;

    protected $guarded = [
    ];
    protected $hidden = [
    ];
    public $table = "driver_customer_reviews";

    public function customer()
    {
        return $this->belongsTo(Customer::class,'customer_id');

    }
    public function driver()
    {
        return $this->belongsTo(Driver::class,'driver_id');

    }
}
