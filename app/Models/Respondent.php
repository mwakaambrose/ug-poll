<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Respondent extends Model
{
    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class);
    }
}
