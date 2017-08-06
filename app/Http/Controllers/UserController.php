<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
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
    public function store(Request $request)
    {
        $this->validate($request, [
            'full_name' => 'required',
            'email' => 'required|unique:users|email',
            'password' => 'required|min:6',
            'birthday' => 'date',
            'phone_number' => 'numeric',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [
            'full_name.required' => 'This name not null',
            'email.email' => 'must be a type of email',
            'email.unique' => 'email has been existed',
            'email.required' => 'This email not null',
            'password.required' => 'This password not null',
            'password.min' => 'min of password is 6 character',
            'birthday.date' => 'This birthday must be a type of date',
            'phone_number.numeric' => 'This field must be number',
            'image.image' => 'Must be an image',
            'image.mimes' => 'The file under validation an image(.jpeg,.png,.gif,.svg)',
        ]);

        $user = new User;
        $user->full_name = $request->get('full_name');
        $user->email = $request->get('email');
        $user->password = bcrypt($request->get('password'));
        $user->gender = $request->get('gender');
        $user->birthday = $request->get('birthday');
        $user->address = $request->get('address');
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $name = $file->getClientOriginalName();
            $nameFile = time() . "-" . $name;
            Image::make($file)->save(public_path('images/users/'. $nameFile));
            $user->image = $nameFile;
        } else {
            $user->image = 'default.jpg';
        }
        $user->save();
        return redirect()->route('users.index');
    }
}
