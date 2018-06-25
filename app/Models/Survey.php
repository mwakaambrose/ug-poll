<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    protected $fillable = [
        'name',
        'description',
        'is_completed',
        'send_time'
    ];

    public function rules()
    {
        return [
            'name' => 'required|string',
            'description' => 'required|string',
            'send_time' => 'nullable|date'
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
