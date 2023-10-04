<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Libs\Misc;
use Request;
class Currency extends BaseModel
{
    public function countries()
    {
        return $this->belongsTo(Countries::class);
    }
}
