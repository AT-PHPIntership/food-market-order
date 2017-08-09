<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

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
        
        return view('users.index')->with('users', $users);
    }

    /**
     * Destroy user
     *
     * @param Integer $id id of user to destroy
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        if (Auth::user()->id == $id) {
            flash(trans('user.delete-error'))->error();
        } else {
            if ($this->user->findOrFail($id)->delete()) {
                flash(trans('user.delete-success'))->success();
            } else {
                flash(trans('user.delete-error'))->error();
            }
        }

        return redirect()->route('users.index');
    }
}
