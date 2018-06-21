<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inbox extends Model
{
    public function respondent()
    {
    	return $this->belongsToMany('App\Respondent','group_respondent');
    }
}
