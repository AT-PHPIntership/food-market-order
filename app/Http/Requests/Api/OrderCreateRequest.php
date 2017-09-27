<?php

namespace App\Http\Requests\Api;

use App\Libraries\Traits\CustomValidationRequest;
use Illuminate\Foundation\Http\FormRequest;

class OrderCreateRequest extends FormRequest
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
            'user_id' => 'required',
            'address_ship' => 'required',
            'trans_at' => 'required',
            'type' => 'required',
            'items' => 'required',
        ];
    }
}
