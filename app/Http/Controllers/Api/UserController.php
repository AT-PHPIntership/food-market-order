<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\UpdateImageRequest;
use App\Http\Requests\Api\UserUpdateRequest;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;
use App\User;
use App\Http\Requests\Api\UserRegisterRequest;
use Illuminate\Http\Response;
use Image;

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
            $response = $http->post(env('APP_URL') . '/oauth/token', [
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

        return response()->json(['data' => $user, 'success' => true], Response::HTTP_OK);
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
        $arrayData = $request->all();
        if (!isset($arrayData['image'])) {
            unset($arrayData['image']);
        }

        if ($request->user()->update($arrayData)) {
            return response()->json(['success' => true], Response::HTTP_OK);
        }

        if (isset($request->all()['image'])) {
            unlink(public_path(config('constant.path_upload_user') . $request->get('image')));
        }
        return response()->json(['success' => false, 'message' => __('Error during update current user!')], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * Save image and response image name
     *
     * @param UpdateImageRequest $request request has image file
     *
     * @return string
     */
    public function postUploadImage(UpdateImageRequest $request)
    {
        if ($request->hasFile('file')) {
            $image = $request->file('file');
            $imageName = time() . $image->getClientOriginalName();
            Image::make($image)->save(public_path('images/users/' . $imageName));
            return $imageName;
        }
        return \response()->json(['success' => false], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * Remove image with file name
     *
     * @param Request $request to remove image
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteImage(Request $request)
    {
        $fileName = $request->get('file_name');
        if (unlink(public_path('images/users/' . $fileName))) {
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false, 'message' => __('Error during remove image')], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
