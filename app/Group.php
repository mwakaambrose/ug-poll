<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    //
    public function respondent($value='')
    {
    	# code...
    	return $this->belongsToMany('App\Respondent','group_respondent');
    }
}
