<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserPostRequest;
use Illuminate\Http\Request;
use App\User;
use Image;

class UserController extends Controller
{
    protected $user;

    /**
     * UserController constructor.
     *
     * @param User $user dependence injection
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get index page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $users = $this->user->paginate(10);
        return view('users.index', ['users', $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request request store data user
     *
     * @return \Illuminate\Http\Response
     */
    public function store(UserPostRequest $request)
    {
        $requestInput = $request->all();

        $this->getImageFileName($request);
        $requestInput['image'] = $this->getImageFileName($request);

        if ($this->user->create($requestInput)) {
            $this->storageImage($request->file('image'), $requestInput['image']);
            flash(__('User Created!'))->success()->important();
            return redirect()->route('users.index');
        } else {
            flash(__('Create User Error'))->error()->important();
            return redirect()->route('users.create')->withInput();
        }
    }

    /**
     * Get filename from request
     *
     * @param Request $request the request need to get file name
     *
     * @return string
     */
    public function getImageFileName(Request $request)
    {
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . "-" . $file->getClientOriginalName();
        } else {
            $fileName = 'default.jpg';
        }
        return $fileName;
    }

    /**
     * Save image file to public/image/users
     *
     * @param File   $file     image file
     * @param string $fileName the name to storage
     *
     * @return void
     */
    public function storageImage(File $file, $fileName)
    {
        if (isset($file)) {
            Image::make($file)->save(public_path('images/users/' . $fileName));
        }
    }
}
