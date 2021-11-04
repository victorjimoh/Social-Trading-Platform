<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
class FollowersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function users()
    {
        $users = User::get();
        return view('users', compact('users'));
    }


    /**
     * Show the application of itsolutionstuff.com.
     *
     * @return \Illuminate\Http\Response
     */
    public function user($id)
    {
        $user = User::find($id);
        return view('userView', compact('user'));
    }


    public function ajaxRequest(Request $request){
        $user = User::find($request->user_id);
        $response = auth()->user()->toggleFollow($user);
        return response()->json(['success'=> $response]);
    }
}

