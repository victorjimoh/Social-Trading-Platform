<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Finnhub;
use GuzzleHttp;
class TestController extends Controller
{
    public function index(){
        $config = Finnhub\Configuration::getDefaultConfiguration()->setApiKey('token', 'c2qvjfaad3iets16ac4g');
        $client = new Finnhub\Api\DefaultApi(
            new GuzzleHttp\Client(),
            $config
        );
        $stockdata = [];
        $data = response()->json($client->symbolSearch("AAPL"));
       return view('test', ['data'=> $data, 'stockdata'=> $stockdata]);  
       /*return response()->json($client->symbolSearch("AAPL")
    );*/
    }
   

}
