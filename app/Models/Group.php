<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = [];

    public function respondents()
    {
        return $this->belongsToMany(Respondent::class);
    }
}
