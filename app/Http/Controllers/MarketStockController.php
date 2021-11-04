<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MarketStockController extends Controller
{
    public function handle()
    {
        $queryString = http_build_query([
            'access_key' => '960986ac937679e2b64c2743b6e0e8c8',
            'symbols' => 'AAPL, AMZN, MSFT, '
        ]);

        $apiURL = sprintf('%s?%s', 'http://api.marketstack.com/v1/eod', $queryString);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiURL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $api_response = curl_exec($ch);
        curl_close($ch);

        $api_result = json_decode($api_response, true);
        dd($api_result['data'][0]['open']);
        return view("marketpages")->with(['apiResult' => $api_result['data'][0]]);
    }
}
