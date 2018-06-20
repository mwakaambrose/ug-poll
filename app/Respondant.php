<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Respondant extends Model
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
