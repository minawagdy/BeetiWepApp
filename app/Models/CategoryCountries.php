<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryCountries extends BaseModel
{
    protected $guarded = [
    ];
    protected $hidden = [];

    public $table = "category_countries";


    public function countries() {
        return $this->belongsTo(Countries::class,'country_id');
    }
    public function category() {
        return $this->belongsTo(Category::class,'category_id');
    }
}
