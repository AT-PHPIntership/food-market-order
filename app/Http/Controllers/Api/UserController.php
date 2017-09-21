<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\UserUpdateRequest;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;
use App\User;
use App\Http\Requests\Api\UserRegisterRequest;
use Illuminate\Http\Response;

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
     * @param UserRegisterRequest $request request store data user
     *
     * @return \Illuminate\Http\Response
     */
    public function store(UserRegisterRequest $request)
    {
        $user = $this->user->create($request->all());
        if (!$user) {
            return response()->json(['success' => false, 'message' => __('Error during create user')], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json(['data' => $user, 'success' => true], Response::HTTP_OK);
    }

    /**
     * Login system and get token for client.
     *
     * @param \Illuminate\Http\Request $request request create
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $http = new Client();
        try {
            $response = $http->post(env('APP_URL').'/oauth/token', [
                'form_params' => [
                    'grant_type' => 'password',
                    'client_id' => env('CLIENT_ID'),
                    'client_secret' => env('CLIENT_SECRET'),
                    'username' => $request->email,
                    'password' => $request->password,
                    'scope' => '',
                ],
            ]);

            return response()->json([
                'data' => json_decode((string) $response->getBody(), true),
                'success' => true
            ], Response::HTTP_OK);
        } catch (ClientException $ex) {
            return  response()->json(
                json_decode($ex->getResponse()->getBody(), true),
                $ex->getCode()
            );
        }
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
        $user = $request->user();
        if (!$user) {
            return response()->json(['success' => false, 'message' => __('Error during get current user')], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        
        return response()->json(['data' => $user,'success' => true], Response::HTTP_OK);
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
     * @param UserUpdateRequest $request request update
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request)
    {
        if ($request->user()->update($request->all())) {
            return response()->json(['success' => true], Response::HTTP_OK);
        }

        return response()->json(['success' => false, 'message' => __('Error during update current user!')], Response::HTTP_INTERNAL_SERVER_ERROR);
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
