<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
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
     * @param UserCreateRequest $request request store data user
     *
     * @return \Illuminate\Http\Response
     */
    public function store(UserCreateRequest $request)
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
            try {
                $userToDel = $this->user->findOrFail($id);
                $userToDel->delete();
                flash(__('Delete Successfully!'))->success()->important();
            } catch (\Exception $ex) {
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
        $user = $this->user->findOrFail($id);
        return view('users.edit', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserUpdateRequest $request request user update
     * @param int               $id      id user update
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, $id)
    {
        $requestInput = $request->except('_method', '_token');
        if ($requestInput['password'] == null) {
            unset($requestInput['password']);
        }
        $requestInput['image'] = $this->getImageFileName($request);
        $userToUpdate = $this->user->findOrFail($id);
        if ($userToUpdate->update($requestInput)) {
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
