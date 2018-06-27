<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Outbox extends Model
{
    //

    public function questions($value='')
    {
    	# code...
    	return $this->belongsTo('App\Question','question_id');
    }

    public function inbox($value='')
    {
    	# code...
    	return $this->hasOne('App\Inbox');
    }
}
