<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Libs\Misc;

class Version extends BaseModel
{
    use HasFactory;

    protected $fillable = [];
    protected $guarded = [
    ];
    protected $hidden = [ 'created_at','updated_at'
    ];
    public $table = "versions";

}
