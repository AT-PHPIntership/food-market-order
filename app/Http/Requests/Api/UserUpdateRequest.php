<?php

namespace App\Http\Requests\Api;

use App\Libraries\Traits\CustomValidationRequest;
use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    use CustomValidationRequest;

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

            'full_name' => 'required',
            'birthday' => 'date',
            'phone_number' => 'required|numeric',
            'address' => 'required',
            'password' => 'nullable|min:6|confirmed',
        ];
    }
}
