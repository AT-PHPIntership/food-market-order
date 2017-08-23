<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\UserCreateAPIRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class UserAPIController extends Controller
{
    protected $user;

    /**
     * UserAPIController constructor.
     *
     * @param User $user Dependence injection
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

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

    /**
     * Store a newly created resource in storage.
     *
     * @param UserCreateAPIRequest $request request store data user
     *
     * @return \Illuminate\Http\Response
     */
    public function store(UserCreateAPIRequest $request)
    {
        return $this->user->create($request->all());
    }
}
