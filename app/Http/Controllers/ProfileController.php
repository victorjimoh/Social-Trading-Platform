<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use App\Models\User;
class ProfileController extends Controller
{
    public function show($id){
        $user = User::find(1);

        $profile = Profile::find($id);
        return view("profile", compact('profile', 'user'));
    }
    public function profile()
    {
        return $this->hasOne('Profile');
    }
}
