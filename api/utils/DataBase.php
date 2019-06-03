<?php
require_once("../settings/AppCfg.php");
class DataBase{

  private $host = AppCfg::DB_HOST;
  private $db = AppCfg::DB_NAME;
  private $dbUser = AppCfg::DB_USER;
  private $dbPass = AppCfg::DB_PASS;
  private $stmt;
  private $dbPDO;
  private $error = null;

  public function __construct(){

    try{
        $this->dbPDO = new PDO("mysql:host=".$this->host.";dbname=".$this->db."",$this->dbUser,$this->dbPass);
    }catch(PDOException $e){
      $this->error = $e->getMessage();
    }
  }

  public function query($query){
      $this->stmt = $this->dbPDO->prepare($query);
  }

  public function bind($param, $value, $type = null){
      if(is_null($type)){
          switch (true){
              case is_int($value):
                $type = PDO::PARAM_INT;
                break;
              case is_bool($value):
                  $type = PDO::PARAM_BOOL;
                  break;
              case is_null($value):
                  $type = PDO::PARAM_NULL;
                  break;
              default:
                  $type = PDO::PARAM_STR;
          }
      }
    $this->stmt->bindValue($param, $value, $type);
  }


  public function execute(){
      return $this->stmt->execute();
  }

  public function resultSet(){
    $this->execute();
    return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function single(){
      $this->execute();
      return $this->stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function getError(){return $this->error;}


}

class DataBaseException extends Exception{
  private $message;

  public function __construct($message){
    $this->message = $message;
  }

  public function errorMessage(){
    return $this->message;
  }
}

 ?>
