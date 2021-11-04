<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Validator,Redirect,Response,File;
use Socialite;
use Auth;
use App\Models\User;

class SocialController extends Controller
{
    public function redirect()
{
    return Socialite::driver('google')->redirect('/home');
}

public function callback()
{
    try {
            $user = Socialite::driver('google')->user();
            $user = User::where('google_id', $user->id)->first();

            if($user){
                Auth::login($user);
                return redirect('/home');
            }else{
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'google_id'=> $user->id,
                    'password' => encrypt('123456dummy12345')
                ]);
                Auth::login($newUser);
                return redirect('/home');
            }
        } catch (Exception $e) {
            dd($e->getMessage());
        }
   }

}

