<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Respondent;

class StoreRespondentsForm extends FormRequest
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
        $rules = [
            'name' => 'required',
            'phone_number' => 'required|digits_between:12,12',
            'address' => 'required',
            'gender' => 'required',
            'district_id' => 'required'
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => 'The Name is required',
            'phone_number.digits_between'   => 'Phone Number should be 12 characters',
            'phone_number.required' => 'The Phone Number is required',
            'address.required' => 'The Address is required',
            'gender.required' => 'Choose a Gender',
            'district_id.required' => 'Choose a District'
        ];
    }

    public function persist(){
        $respondent = new Respondent($this->all());
        if (!$respondent->save()) {
            return response()->json(["errors"=>$this->name.'not saved!']);
        }else {
            foreach ($this->group as $group_id) {
                try {
                    \DB::table('group_respondent')->insert([['respondent_id' => $respondent->id, 'group_id' => $group_id], ]); 
                } catch (\Exception $e) {
                    return $e->getMessage();
                }
            }
            return response()->json(["success"=>"Respondent $this->name. saved."]);
        }
    }
}
