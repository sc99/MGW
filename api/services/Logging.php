<?php
    require_once('../settings/AppCfg.php');
    require_once("../models/UserModel.php");

    session_start();

    $userMail = isset($_POST["usermail"]) ? $_POST["usermail"] : null;
    $userPswd = isset($_POST["userpassword"]) ? md5($_POST["userpassword"]) : null;

    if(is_null($userMail) || is_null($userPswd))
      echo AppCfg::NULL_PARAMETERS_FOUND;
    else{
        $userModel = new UserModel($userMail,$userPswd);
        $_SESSION['isLogged'] =  $userModel->getUserId();
        echo $userModel->logUser();
    }

 ?>
