<?php
require_once("../utils/DataBase.php");
class UserModel{
  private $userMail;
  private $userPswd;
  private $userId;

  public function __construct($userMail,$userPswd){
    $this->userMail = $userMail;
    $this->userPswd = $userPswd;

  }

  public function logUser(){
      $dataBase = new DataBase();
      $jsonResponse = null;
      try{
        if(!is_null($dataBase->getError()))
          throw new UserLoggingException($dataBase->error);
        else{
          $dataBase->query("call sp_log_user(:mail,:pswd)");
          $dataBase->bind(':mail',$this->userMail);
          $dataBase->bind(':pswd',$this->userPswd);
          $row = $dataBase->single();
          $this->userId = $row['RESULT'];
          $jsonResponse = json_encode(array("result" => $this->userId,"message"=> $row['MESSAGE']));
        }
      }catch(UserLoggingException $e){
        $jsonResponse = json_encode(array("result" => 0, "message" =>$e->getMessage()));
      }
      $dataBase = null;
      return $jsonResponse;
  }

  public function getUserId(){
    return $this->userId;
  }
}

 class UserLoggingException extends Exception{

  protected $message;

  public function __construct($message){
    $this->message = $message;
  }
  public function errorMessage(){
    return $this->message;
  }
}


 ?>
