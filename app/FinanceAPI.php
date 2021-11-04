<?php
namespace App;
use App\ApiUri;

class FinanceAPI
{
    public static function getAllStockInfo(array $tickers)
    {
        $accesskey = "?access_key=";
        $symbols = "&symbols=";
        
        foreach($tickers as $ticker){
            $symbols .= $ticker. ",";
        }
        $symbols = substr($symbols, 0 , strlen($symbols) - 1);
        $strJson = file_get_contents("http://api.marketstack.com/v1/eod". $accesskey . "9cd884536356359bca4bd308f7c07cde" . $symbols);
        return json_decode($strJson, true);
    }
    
}

