<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\UserUpdateRequest;
use Illuminate\Http\Request;

class UserController extends ApiController
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserUpdateRequest $request request create
     *
     * @return \Illuminate\Http\Response
     */
    public function store(UserUpdateRequest $request)
    {
        $user = $this->user->create($request->all());
        if (!$user) {
            return response()->json(['success' => 'false', 'message' => 'Cannot registry user right now!, please try again later!'], 500);
        } else {
            return response()->json(['success' => 'true', 'message' => 'Registry successfully!, please login and enjoy!'], 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id id user
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        return $request->user();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id id user
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id = $id;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request request update
     * @param int                      $id      id user update
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request = $request;
        $id = $id;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id id delete
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $id = $id;
    }
}
