<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    public function outbox()
    {
    	return $this->hasMany('App\Outbox');
    }

    public function survey()
    {
      	return $this->belongsTo('App\Survey');
    }
}
