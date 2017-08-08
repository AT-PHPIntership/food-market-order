<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
           'name' => 'required|unique:categories|max:255',
           'description' => 'required',
         ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => ' The category name field is required.',
            'name.max' => ' The category name may not be greater than 255 characters.',
            'name.unique' => ' The category name is existed.',
            'description.required' => ' The description field is required.',
        ];
    }
}
