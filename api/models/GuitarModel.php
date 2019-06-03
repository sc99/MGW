<?php
foreach (glob("../utils/catalogues/*.php") as $filename)
{
    require_once($filename);
}
require_once("../settings/AppCfg.php");
require_once("../utils/DataBase.php");

class GuitarModel{
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

  public function getAllGuitars(){
    $dataBase = new DataBase();
    $arrayGuitars = array();
    try{
      if(!is_null($dataBase->getError()))
        throw new DataBaseException($dataBase->error);
      else{
        $dataBase->query("select * from vw_guitars");
        $guitars = $dataBase->resultSet();
        if(sizeof($guitars) > 0)
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
            array_push($arrayGuitars,$guitar);
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
