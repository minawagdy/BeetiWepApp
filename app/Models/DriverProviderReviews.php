<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverProviderReviews extends BaseModel
{
    use HasFactory;

    protected $guarded = [
    ];
    protected $hidden = [
    ];
    public $table = "driver_provider_reviews";

    public function provider()
    {
        return $this->belongsTo(Provider::class,'provider_id');

    }
    public function driver()
    {
        return $this->belongsTo(Driver::class,'driver_id');

    }
}
