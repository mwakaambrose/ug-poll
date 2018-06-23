<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Outbox extends Model
{
    public function questions()
    {
    	return $this->belongsTo('App\Question','question_id');
    }

    public function inbox()
    {
    	return $this->hasOne('App\Inbox');
    }
}
