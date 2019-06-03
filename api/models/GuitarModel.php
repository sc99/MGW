<?php
foreach (glob("../utils/catalogues/*.php") as $filename)
{
    require_once($filename);
}
require_once("../settings/AppCfg.php");
require_once("../utils/DataBase.php");

class GuitarModel  {
  private $id;
  private $model;
  private $price;
  private $kaoss;
  private $sustainer;
  private $body;
  private $freetboard;
  private $bridge;
  private $pickups;
  private $strings;
  private $effect;
  private $wood;
  private $url;

  public function __construct(){

  }

  public static function basedOnParams($id,$model,$price,$kaoss,$sustainer,$body,$freetboard,$bridge,$pickups,$strings,$effect,$wood,$url){
    $instance = new self();
    $instance->id = $id;
    $instance->model = $model;
    $instance->price= $price;
    $instance->kaoss = $kaoss;
    $instance->sustainer = $sustainer;
    $instance->body = $body;
    $instance->freetboard = $freetboard;
    $instance->bridge = $bridge;
    $instance->pickups = $pickups;
    $instance->strings = $strings;
    $instance->effect = $effect;
    $instance->wood = $wood;
    $instance->url = $url;
    return $instance;
  }

  public function setId($id){$this->id = $id;}
  public function setModel($model){$this->model = $model;}
  public function setPrice($price){$this->price = $price;}
  public function setKaoss($kaoss){$this->kaoss = $kaoss;}
  public function setSustainer($sustainer){$this->sustainer = $sustainer;}
  public function setBody($body){$this->body = $body;}
  public function setFreetboard($freetboard){$this->freetboard = $freetboard;}
  public function setBridge($bridge){$this->bridge = $bridge;}
  public function setPickups($pickups){$this->pickups = $pickups;}
  public function setStrings($strings){$this->strings = $strings;}
  public function setEffect($effect){$this->effect = $effect;}
  public function setWood($wood){$this->wood = $wood;}
  public function setUrl($url){$this->url = $url;}

  public function getId(){return $this->id;}
  public function getModel(){return $this->model;}
  public function getPrice(){return $this->price;}
  public function getKaoss(){return $this->kaoss;}
  public function getSustainer(){return $this->sustainer;}
  public function getBody(){return $this->body;}
  public function getFreetboard(){return $this->freetboard;}
  public function getBridge(){return $this->bridge;}
  public function getPickups(){return $this->pickups;}
  public function getStrings(){return $this->strings;}
  public function getEffect(){return $this->effect;}
  public function getWood(){return $this->wood;}
  public function getUrl(){return $this->url;}



  private function fetchGuitarParts($db){
    $bodyArray = array();
    $bridgeArray = array();
    $effectArray = array();
    $freetboardArray = array();
    $pickupsArray= array();
    $stringsArray = array();
    $woodsArray = array();
    $db->query("select * from cat_bodies");
    $resultSet = $db->resultSet();
    foreach($resultSet as $body)
      array_push($bodyArray,$body);
    $db->clearFetch();

    $db->query("select * from cat_bridges");
    $resultSet = $db->resultSet();
    foreach($resultSet as $bridge)
      array_push($bridgeArray,$bridge);
    $db->clearFetch();

    $db->query("select * from cat_effects");
    $resultSet = $db->resultSet();
    foreach($resultSet as $effect)
      array_push($effectArray,$effect);
    $db->clearFetch();

    $db->query("select * from cat_freetboards");
    $resultSet = $db->resultSet();
    foreach($resultSet as $freet)
      array_push($freetboardArray,$freet);
    $db->clearFetch();

    $db->query("select * from cat_pickups");
    $resultSet = $db->resultSet();
    foreach($resultSet as $pickup)
      array_push($pickupsArray,$pickup);
    $db->clearFetch();

    $db->query("select * from cat_strings");
    $resultSet = $db->resultSet();
    foreach($resultSet as $string)
      array_push($stringsArray,$string);
    $db->clearFetch();

    $db->query("select * from cat_woods");
    $resultSet = $db->resultSet();
    foreach($resultSet as $wood)
      array_push($woodsArray,$wood);
    $db->clearFetch();

    return json_encode(array(
      "result" => 1,
      "bodies" => $bodyArray,
      "bridges" => $bridgeArray,
      "effects" => $effectArray,
      "freet" => $freetboardArray,
      "picks" => $pickupsArray,
      "strings" => $stringsArray,
      "woods" => $woodsArray
    ));
  }

  public function addGuitar($model,$kaoss,$sustainer,$price,$body,$freet,$bridge,$picks,$strings,$effect,$wood){
    $dataBase = new DataBase();
    $jsonResponse = null;

    try{
      if(!is_null($dataBase->getError()))
        throw new DataBaseException($dataBase->error);
      else{
        $dataBase->query("call sp_add_guitar(:model,:kaoss,:sustainer,:price,:body,:freet,:bridge,:picks,:strings,:effect,:wood)");
        $dataBase->bind(":model",$model);
        $dataBase->bind(":kaoss",$kaoss);
        $dataBase->bind(":sustainer",$sustainer);
        $dataBase->bind(":price",$price);
        $dataBase->bind(":body",$body);
        $dataBase->bind(":freet",$freet);
        $dataBase->bind(":bridge",$bridge);
        $dataBase->bind(":picks",$picks);
        $dataBase->bind(":strings",$strings);
        $dataBase->bind(":effect",$effect);
        $dataBase->bind(":wood",$wood);
        $row = $dataBase->single();
        $jsonResponse = json_encode(array("result"=>$row['ERROR'],"message"=>$row['MESSAGE']));
      }
    }catch(DataBaseException $e){
      $jsonResponse = json_encode(array("result" => 0, "message" =>$e->getMessage()));
    }
    $dataBase = null;
    return $jsonResponse;
  }

  public function deleteGuitar($signatureId){
    $dataBase = new DataBase();
    $jsonResponse = null;

    try{
      if(!is_null($dataBase->getError()))
        throw new DataBaseException($dataBase->error);
      else{
        $dataBase->query("call sp_delete_guitar(:guitar)");
        $dataBase->bind(":guitar",$signatureId);
        $row = $dataBase->single();
        $jsonResponse = json_encode(array("result"=>$row['ERROR'],"message"=>$row['MESSAGE']));
      }
    }catch(DataBaseException $e){
      $jsonResponse = json_encode(array("result" => 0, "message" =>$e->getMessage()));
    }
    $dataBase = null;
    return $jsonResponse;
  }

  public function getGuitarParts(){
    $dataBase = new DataBase();
    $jsonResponse = null;

    try{
      if(!is_null($dataBase->getError()))
        throw new DataBaseException($dataBase->error);
      else{
        $jsonResponse = $this->fetchGuitarParts($dataBase);
      }
    }catch(DataBaseException $e){
      $jsonResponse = json_encode(array("result" => 0, "message" =>$e->getMessage()));
    }
    $dataBase = null;
    return $jsonResponse;
  }

  public function getAllGuitars(){
    $dataBase = new DataBase();
    $arrayGuitars = array();
    try{
      if(!is_null($dataBase->getError()))
        throw new DataBaseException($dataBase->error);
      else{
        $dataBase->query("select * from vw_guitars");
        $guitars = $dataBase->resultSet();
        if(sizeof($guitars) > 0){
          foreach($guitars as $guitar){
              $guitar = self::basedOnParams(
                $guitar['ID'],
                $guitar['MODEL'],
                $guitar['PRICE'],
                $guitar['KAOSS'],
                $guitar['SUSTAINER'],
                $guitar['BODY'],
                $guitar['FREETBOARD'],
                $guitar['BRIDGE'],
                $guitar['PICKUPS'],
                $guitar['STRINGS'],
                $guitar['EFFECT'],
                $guitar['WOOD'],
                $guitar['IMAGE']
              );
            array_push($arrayGuitars,$guitar->toJson());
          }
        //  echo json_encode(array("Guitars"=>$arrayGuitars));
        }
        else
          $arrayGuitars = null;
      }
    }catch(DataBaseException $e){
      throw new DataBaseException($e->getMessage());
    }
    $dataBase = null;
    return $arrayGuitars;
  }

  public function validateGuitarParts(){
    try{
      if(!GuitarBodies::isValidBody($body))
        throw new InvalidGuitarPartException(AppCfg::INVALID_GUITAR_PART."Cuerpo");
      elseif (!GuiarBridges::isValidBridge($bridge))
        throw new InvalidGuitarPartException(AppCfg::INVALID_GUITAR_PART."Puente");
      elseif(!GuitarEffects::isValidEffect($effect))
        throw new InvalidGuitarPartException(AppCfg::INVALID_GUITAR_PART."Efecto embebido");
      elseif(!GuitarFreetboards::isValidFreetboard($freetboard))
        throw new InvalidGuitarPartException(AppCfg::INVALID_GUITAR_PART."Mástil");
      elseif(!GuitarPickups::isValidPickup($pickups))
        throw new InvalidGuitarPartException(AppCfg::INVALID_GUITAR_PART."Pastillas");
      elseif (!GuitarStrings::isValidString($strings))
        throw new InvalidGuitarPartException(AppCfg::INVALID_GUITAR_PART."Cuerdas");
      elseif(!GuitarWoods::isValidWood($wood))
        throw new InvalidGuitarPartException(AppCfg::INVALID_GUITAR_PART."Madera");
      else
        return true;
    }catch(InvalidGuitarPartException $e){
      throw new InvalidGuitarPartException($e->getMessage());
    }
  }


public function toJson(){
  $json = array(
    "id"=>$this->id,
    "model"=>$this->model,
    "price"=>$this->price,
    "kaoss"=>$this->kaoss,
    "sustainer"=>$this->sustainer,
    "body"=>$this->body,
    "freetboard"=>$this->freetboard,
    "bridge"=>$this->bridge,
    "pickups"=>$this->pickups,
    "strings"=>$this->strings,
    "effect"=>$this->effect,
    "wood"=>$this->wood,
    "image"=>$this->url
  );
  return $json;
}

}

class InvalidGuitarPartException extends Exception{
  protected $message;

  public function __construct($message){
    $this->message = $message;
  }

  public function errorMessage(){
    return $this->message;
  }
}

 ?>
