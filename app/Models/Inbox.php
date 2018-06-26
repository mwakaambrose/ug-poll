<?php

namespace App\Models;

use App\Models\Respondent;
use Illuminate\Database\Eloquent\Model;

class Inbox extends Model
{
    public function respondent()
    {
    	return $this->belongsToMany(Respondent::class, 'group_respondent');
    }
}
