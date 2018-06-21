<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    //
    public function outbox($value='')
    {
    	# code...
    	return $this->hasMany('App\Outbox');
    }

    public function survey($value='')
    {
      	return $this->belongsTo('App\Survey');
    }
}
