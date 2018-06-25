<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = ['name', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function respondents()
    {
        return $this->belongsToMany(Respondent::class);
    }

    public function surveys()
    {
        return $this->hasMany(Survey::class);
    }
}
