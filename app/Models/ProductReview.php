<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Libs\Misc;
use Request;
class ProductReview extends BaseModel
{
    protected $guarded = [
    ];
    protected $hidden = [
    ];

    protected $fillable = [
        'product_id',
        'customer_id',
        'rate',
        'note'
        
    ];
    public $table = "products_reviews";

    public function product()
    {
        return $this->belongsTo(Product::class,'product_id');
      
    }
    public function customer()
    {
        return  $this->belongsTo(Customer::class);
    }

    

}
