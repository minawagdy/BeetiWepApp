<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Libs\Misc;

class ProviderReview extends BaseModel
{
    protected $fillable = ['user_id','rate','provider_id','notes'];
    protected $guarded = [
    ];
    protected $hidden = [
    ];
    public $table = "provider_reviews";


    public function provider() {
        return $this->belongsTo('\App\Models\Provider',"provider_id");
    }
    public function customer() {
        return $this->belongsTo(Customer::class,'user_id');
    }

}
