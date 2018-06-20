<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    //
    public function district($value='')
    {
        # code...
        return $this->hasMany('App\District');
    }
}
