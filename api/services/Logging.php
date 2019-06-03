<?php
    require_once('../settings/AppCfg.php');
    require_once("../models/UserModel.php");

    session_start();

    $action = isset($_POST['action']) ? $_POST['action'] : null;
    if(!is_null($action)){
      switch($action){
        case AppCfg::LOG_IN_ACTION:
          $userMail = isset($_POST["usermail"]) ? $_POST["usermail"] : null;
          $userPswd = isset($_POST["userpassword"]) ? md5($_POST["userpassword"]) : null;

          if(is_null($userMail) || is_null($userPswd))
            echo AppCfg::NULL_PARAMETERS_FOUND;
          else{
              $userModel = new UserModel($userMail,$userPswd);
              $response = $userModel->logUser();
              $_SESSION['isLogged'] =  $userModel->getUserId();
              echo $response;
          }
        break;
        case AppCfg::LOG_OUT_ACTION:
          $_SESSION['isLogged'] = null;
          echo json_encode(array("result"=>1));
        break;
        default:
          echo AppCfg::UNRECOGNIZED_ACTION;
      }
    }else
      echo AppCfg::UNRECOGNIZED_ACTION;

 ?>
