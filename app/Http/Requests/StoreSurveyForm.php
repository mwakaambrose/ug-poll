<?php

namespace App\Http\Requests;

use Auth;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\Survey;

class StoreSurveyForm extends FormRequest
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
            'name' => 'required',
            'description' => 'required',
            'group_id' => 'required',
            'send_time' => 'required|date',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The Name field is required',
            'description.required' => 'The Description field is required',
            'group_id.required' => 'The Group field is required',
            'send_time.required' => 'The Send Time is required',
            'send_time.date' => 'Use the right date format',
        ];
    }

    public function persist(){
        $survey = new Survey($this->all());
        $survey->group_id = $this->group_id;
        $survey->user_id = Auth::user()->id;
        if(!$survey->save()){
            return response()->json(["errors"=>"$this->name not saved!"]);
        }else{
            return response()->json(["success"=>"Survey $this->name. successfully saved."]);
        }
    }
}
