<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = $this->user->paginate(User::ITEMS_PER_PAGE);
        return view('users.index')->with('users', $users);
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
    public function store(UserRequest $request)
    {
        $requestInput = $request->all();

        $this->getImageFileName($request);
        $requestInput['image'] = $this->getImageFileName($request);

        if ($this->user->create($requestInput)) {
            if ($request->hasFile('image')) {
                $this->storageImage($request->file('image'), $requestInput['image']);
            }
            flash(__('User Created!'))->success()->important();
            return redirect()->route('users.index');
        } else {
            flash(__('Create User Error'))->error()->important();
            return redirect()->route('users.create')->withInput();
        }
    }

    /**
     * Destroy user
     *
     * @param Integer $id id of user to destroy
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        if (Auth::user()->id == $id) {
            flash(__('Cannot delete current user!'))->error()->important();
        } else {
            if ($this->user->findOrFail($id)->delete()) {
                flash(__('Delete Successfully!'))->success()->important();
            } else {
                flash(__('Delete Error!'))->error()->important();
            }
        }
        return redirect()->route('users.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id id user update
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if ($user = $this->user->findOrFail($id)) {
            return view('users.edit', ['user' => $user]);
        } else {
            flash(__('Error! nothing to show!'))->error()->important();
            return redirect()->route('users.index');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request request user update
     * @param int                      $id      id user update
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        $requestInput = $request->except('_method', '_token');
        $requestInput['password'] = ($requestInput['password'] === $this->user->findOrFail($id)) ? $requestInput['password'] : bcrypt($requestInput['password']);
        $requestInput['image'] = $this->getImageFileName($request);
        if ($this->user->where('id', $id)->update($requestInput) >= 1) {
            if ($request->hasFile('image')) {
                $this->storageImage($request->file('image'), $requestInput['image']);
            }
            flash(__('Update Successfully'))->success()->important();
            return redirect()->route('users.edit', $id);
        } else {
            flash(__('Update Error'))->error()->important();
            return redirect()->route('users.edit', $id)->withInput();
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
    public function storageImage($file, $fileName)
    {
        Image::make($file)->save(public_path('images/users/' . $fileName));
    }
}
