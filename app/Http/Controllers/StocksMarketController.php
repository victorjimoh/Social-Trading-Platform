<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Finnhub;
use GuzzleHttp;

class StocksMarketController extends Controller
{
    public function index()
    {
        try {
            $config = Finnhub\Configuration::getDefaultConfiguration()->setApiKey('token', 'c2qvjfaad3iets16ac4g');
            $client = new Finnhub\Api\DefaultApi(
                new GuzzleHttp\Client(),
                $config
            );

            //file_put_contents('temp.json', json_encode($client->symbolSearch("AAPL")['result']));
            return response()->json(array($client->symbolSearch("AAPL")));
        } catch (Exception $e) {
            echo "An error Occurred";
        }
        //return view('trademarkets', ['data'=> $data]);
    }
}
