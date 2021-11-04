<?php

namespace App\Classes;

class Res_Cleanup {

    public function __construct($res) {

      $this->response = $res;
      $this->params = ['title', 'article_url', 'description', 'image_url', 'author'];
      $this->data = [];
    }

    public function cleanup_res() {

      list($param_one, $param_two, $param_three, $param_four, $param_five) = $this->params;

        foreach($this->response as $res){
          
          $obj = new \stdClass;

          $obj->$param_one = $this->checkParam($param_one, $res);
          $obj->$param_two = $this->checkParam($param_two, $res);
          $obj->$param_three = $this->checkParam($param_three, $res);
          $obj->$param_four = $this->checkParam($param_four, $res);
          $obj->$param_five = $this->checkParam($param_five, $res);

           $id = $res['id'];
           $this->data[$id] = $obj;
          }

        return $this->data;
    }

    public function checkParam($param, $data){

      return isset($data[$param]) === true && !empty($data[$param]) === true ? $data[$param] : '';
    }

}
