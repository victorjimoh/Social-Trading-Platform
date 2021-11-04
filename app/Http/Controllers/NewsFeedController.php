<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NewsFeedController extends Controller
{
    public function __construct(){
        $this->middleware(['auth']);
    }
}
