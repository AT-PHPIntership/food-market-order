<?php

namespace App\Libraries\Traits;

use Illuminate\Http\Response;

trait CustomValidationRequest
{

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
