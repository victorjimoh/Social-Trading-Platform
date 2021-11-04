<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StocksCalculatorController extends Controller
{
    public function index(){
        return view('stockcalculator');
    }
    
}
