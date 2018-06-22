<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $fillable = ['region_id', 'name'];

    public function respondents()
    {
        return $this->hasMany(Respondent::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }
}
