<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class UserRegisterRequest extends FormRequest
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
            'full_name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ];
    }

    /**
     * Get the proper failed validation response for the request.
     *
     * @param array $errors fail information of validation
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function response(array $errors)
    {
        return response()->json($errors, Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
