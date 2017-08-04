<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
}
