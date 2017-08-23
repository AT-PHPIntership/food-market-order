<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\UserCreateApiRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class UserApiController extends Controller
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
        $user = $this->user->create($request->all());
        if (!$user) {
            return response()->json(['success' => 'false', 'message' => 'Cannot registry user right now!, please try again later!'], 500);
        } else {
            return response()->json(['success' => 'true', 'message' => 'Registry successfully!, please login and enjoy!'], 200);
        }
    }
}
