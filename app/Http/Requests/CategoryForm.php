<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Category;

class CategoryForm extends FormRequest
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
            'name' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Enter a Category'
        ];
    }

    public function persist(){
        $category = new Category($this->all());

        if(!$category->save()){
            return response()->json(["errors"=>"$this->name category not saved!"]);
        }else{
            return response()->json(["success"=>"Survey $this->name. category successfully saved."]);
        }
    }
}
