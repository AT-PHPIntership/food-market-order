<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserPutRequest;
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
        $users = $this->user->paginate(10);

        return view('users.index')->with('listUsers', $users);
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
            flash(trans('user.no-data'))->error()->important();
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
    public function update(UserPutRequest $request, $id)
    {
        $arr = $request->except('_method', '_token');
        $arr['password'] = ($arr['password'] === $this->user->findOrFail($id)) ? $arr['password'] : bcrypt($arr['password']);
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . "-" . $file->getClientOriginalName();
            Image::make($file)->save(public_path('images/users/' . $fileName));
            $arr['image'] = $fileName;
        }
        $this->user->where('id', $id)->update($arr) >= 1 ? flash(__('Update Successfully'))->success()->important() : flash(trans('Update Error'))->error()->important();
        return redirect()->route('users.edit', $id);
    }
}
