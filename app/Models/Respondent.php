<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Respondent extends Model
{
    protected $fillable = [
        'district_id',
        'name',
        'phone_number',
        'address',
        'gender',
        'email',
    ];

    public function rules()
    {
        return [
            'district_id'   => 'nullable|integer',
            'name'          => 'required|string',
            'phone_number'  => 'required|string',
            'address'       => 'required|string',
            'gender'        => 'required|string',
            'email'         => 'nullable|string',
        ];
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class);
    }
}
