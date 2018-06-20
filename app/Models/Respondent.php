<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Respondent extends Model
{
    //
    public function district($value='')
    {
        # code...
        return $this->belongsTo('App\District');
    }

    public function group($value='')
    {
        # code...
        return $this->belongsToMany('App\Group');
    }
}
