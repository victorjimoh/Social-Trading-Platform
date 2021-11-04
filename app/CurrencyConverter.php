<?php

namespace App;

class CurrencyConverter{
    public static function convertToUSD($currency, $value){
        $pairs = "USD" . $currency;
        $json = file_get_contents("https://www.freeforexapi.com/api/live?pairs=" .$pairs);
        $data = json_decode($json);
        //dd($data);
        $rate = $data->rates->$pairs->rate;
        return $value / $rate;
    }
}















