<?php

namespace App\Http\Controllers\Api;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends ApiController
{
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
     * @param \Illuminate\Http\Request $request request create
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request = $request;
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
                    'client_id' => 2,
                    'client_secret' => '9qVYHF8PXUJUKTv0pXPdfbdCeQ3m2BnuMBccW8PQ',
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
            return json_decode($ex->getResponse()->getBody(), true);
        }
    }


    /**
     * Display the specified resource.
     *
     * @param int $id id user
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $id = $id;
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
