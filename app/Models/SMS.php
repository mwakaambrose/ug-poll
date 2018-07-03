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
        'survey_id',
    ];

    public function rules()
    {
        return [
            'sms_action' => 'required|string',
            'minimum_weight' => 'required|numeric',
            'maximum_weight' => 'required|numeric',
            'survey_id'=>'required',
        ];
    }

    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }
}
