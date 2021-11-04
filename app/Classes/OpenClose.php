<?php

namespace App\Classes;

use App\Classes\TickerNewsV2;
use PolygonIO\rest\Rest;

class OpenClose extends TickerNewsV2{

  public function __construct(){

    $api = $this->_getApi();
    $this->apiKey = $api['api_key'];
    $this->tickr = '';
    $this->date = date("Y-m-d", strtotime("-2 day"));
    $this->response = ['success' => false];
  }

  public function getTckr($tickr){
    $this->tickr = $tickr;
  }

  public function getPrices(){
    $rest = new Rest($this->apiKey);

    try{
      $price = $rest->stocks->dailyOpenClose->get($this->tickr, $this->date);
      $this->response['success'] = true;
      $this->response['openP'] = $price['open'];

    }catch(\Throwble $th){
      return $this->response;
    }

    return $this->response;
  }

}
