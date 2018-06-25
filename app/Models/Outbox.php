<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Outbox extends Model
{
    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function inbox()
    {
        return $this->hasOne(Inbox::class);
    }

    public function respondent()
    {
        return $this->belongsTo(Respondent::class);
    }
}
