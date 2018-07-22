<?php

namespace App\Http\Requests;

use App\Models\SMS;
use Illuminate\Foundation\Http\FormRequest;

class StoreSMS extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'survey_id' => 'required',
            'minimum_weight' => 'required',
            'maximum_weight' => 'required',
            'category_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'survey_id.required' => 'Choose a Survey',
            'minimum_weight.required' => 'Enter the Minimum Weight',
            'maximum_weight.required' => 'Enter the Maximum Weight',
            'category_id.required' => 'Choose a Category'
        ];
    }

    public function persist(){
        $sms = new SMS($this->all());
        if (!$sms->save()) {
            return response()->json(["errors"=>"Failed to save SMS Action"]);
        }else{
            return response()->json(["success"=>"SMS Action successfully saved."]);
        }
    }
}
