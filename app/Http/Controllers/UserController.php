<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Image;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!isset($listUsers)) {
            $listUsers = User::all();
        }

        return view('users.index')->with('listUsers', $listUsers);
    }

    /**
     * <<<<<<< HEAD
     * Show the form for editing the specified resource.
     *
     * @param int $id id user update
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);

        return view('users.edit', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request request user update
     * @param int                      $id      id user update
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'full_name' => 'required',
            'password' => 'required|min:6',
            'birthday' => 'date',
            'phone_number' => 'numeric|required',
        ], [
            'full_name.required' => 'This name not null',
            'email.required' => 'This email not null',
            'password.required' => 'This password not null',
            'password.min' => 'min of password is 6 character',
            'birthday.date' => 'This birthday must be a type of date',
            'phone_number.numeric' => 'This field must be number',
            'phone_number.required' => 'please put your phone number here',
        ]);

        $user = User::find($id);
        $user->full_name = $request->get('full_name');
        if (!$request->get('password') == 'default') {
            $user->password = bcrypt($request->get('password'));
        }
        $user->gender = $request->get('gender');
        $user->birthday = $request->get('birthday');
        $user->address = $request->get('address');
        $user->phone_number = $request->get('phone_number');
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $name = $file->getClientOriginalName();
            $nameFile = time() . "-" . $name;
            Image::make($file)->save(public_path('images/users/' . $nameFile));
            $user->image = $nameFile;
        }

        if ($user->save()) {
            flash('update successfully')->success();
        } else {
            flash('update error')->error();
        }

        return redirect()->route('users.edit', $id);
    }
}
