<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\User;
use App\Models\Follow;

class PostController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth']);
    }
    
    public function index()
    {
        $user = Auth::user();
   
        $profile = Post::where('user_id', $user->id)->orderBy('id', 'desc')->paginate(2);
        return view('profile', [
            'profile' => $profile,
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'body' => 'required'
        ]);
        $request->user()->posts()->create([
            'body' => $request->body
        ]);
        return redirect()->route('profile');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /**public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Post::find($id);
        $data->delete();
        return redirect()->route('profile');
    }
}





