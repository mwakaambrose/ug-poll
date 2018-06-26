<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SMS extends Model
{
    protected $table = "s_m_s";

    protected $fillable = [
        'sms_action',
        'minimum_weight',
        'maximum_weight',
    ];

    public function rules()
    {
        return [
            'sms_action' => 'required|string',
            'minimum_weight' => 'required|numeric|between:0, 9999.999',
            'maximum_weight' => 'required|numeric|between:0, 9999.999',
        ];
    }
}
