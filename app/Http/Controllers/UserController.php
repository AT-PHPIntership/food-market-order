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
        $arr = $request->all();
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . "-" . $file->getClientOriginalName();
            $arr['image'] = $fileName;
        } else {
            $arr['image'] = 'default.jpg';
        }

        if ($this->user->create($arr)) {
            if (isset($file)) {
                Image::make($file)->save(public_path('images/users/'. $fileName));
            }
            flash(__('User Created!'))->success()->important();
        } else {
            flash(__('Create User Error'))->error()->important();
        }
        return redirect()->route('users.index');
    }
}
