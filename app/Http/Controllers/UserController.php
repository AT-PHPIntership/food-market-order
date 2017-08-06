<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Laracasts\Flash\Flash;

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
     * Destroy user
     *
     * @param $id id of user to destroy
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        if (Auth::user()->id == $id) {

            \flash('can not delete yourself!')->error();
        }
        else {
            if (User::findOrFail($id)->delete()) {

                \flash('delete successfully!')->success();
            } else {

                \flash('can not delete yourself!')->error();
            }
        }

        return redirect()->route('users.index');
    }
}
