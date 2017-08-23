<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserAPIController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param Request $request request get user information
     *
     * @return mixed
     */
    public function show(Request $request)
    {
        return $request->user();
    }
}
