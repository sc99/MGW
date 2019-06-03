<?php
require_once("../utils/DataBase.php");
class OrderModel{

private $id;
private $client;
private $card;
private $ccv;
private $signature;

public function __construct(){}

public static function basedOnParams($id,$client,$card,$ccv,$signature){
  $instance = self();
  $instance->id = $id;
  $instance->client = $client;
  $instance->card = $card;
  $instance->ccv = $ccv;
  $instance->signature = $signature;
  return $instance;
}

public function addOrder($orderName,$orderSurname,$orderLastname,$orderCard,$orderCcv,$orderGuitar){
  $dataBase = null;
  $jsonResponse = null;
  try{
    $dataBase = new DataBase();
    $jsonResponse = null;

    if(!is_null($dataBase->getError()))
      throw new DataBaseException($dataBase->error);
    else{
      /*$dataBase->query("call sp_log_user(:mail,:pswd)");
      $dataBase->bind(':mail',$orderName);
      $dataBase->bind(':pswd',$orderSurname);*/
     $dataBase->query("call sp_add_order(:orderName,:orderSurname,:orderLastname,:orderCard,:orderCcv,:orderGuitar)");
      $dataBase->bind(':orderName',$orderName);
      $dataBase->bind(':orderSurname',$orderSurname);
      $dataBase->bind(':orderLastname',$orderLastname);
      $dataBase->bind(':orderCard',$orderCard);
      $dataBase->bind(':orderCcv',$orderCcv);
      $dataBase->bind(':orderGuitar',$orderGuitar);
      $row = $dataBase->single();
      $jsonResponse = json_encode(array("result" => $row['RESULT'],"message" => $row['MESSAGE']));

    }
  }catch(DataBaseException $e){
    $jsonResponse = json_encode(array("result" => 0, "message" =>$e->getMessage()));
  }
  $dataBase = null;
  return $jsonResponse;
}


public function toJson(){
  $json = array(
    "id"=>$this->id,
    "client"=>$this->client,
    "card"=>$this->card,
    "ccv"=>$this->ccv,
    "guitar"=>$signature->toJson()

  );

  return $json;
}

}
 ?>
