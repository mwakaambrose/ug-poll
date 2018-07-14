<?php

namespace App\Http\Requests;

use App\Models\Respondent;
use Illuminate\Foundation\Http\FormRequest;

class RespondentStoreRequest extends FormRequest
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
            'name' => 'required|unique:respondent',
            'phone_number' => 'required|digits_between:12,12',
            'address' => 'required',
            'gender' => 'required',
        ]
        // return (new Respondent)->rules();
    }
}
