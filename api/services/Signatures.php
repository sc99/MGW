<?php
require_once("../settings/AppCfg.php");
require_once("../models/GuitarModel.php");

$action = isset($_POST['action']) ? $_POST['action'] : null;

if(!is_null($action)){
  swicth($action){
    case AppCfg::ALL_SIGNATURES_ACTION:
      $guitarModel = new GuitarModel();
      try{
          $guitarModel = $guitarModel->getAllGuitars();
          if(!is_null($guitarModel)){
            echo json_encode(array("result" => 1,"guitars"=>$guitarModel));
          }else
              echo json_encode(array("result"=>-1,"message" => AppCfg::NO_SIGNATURES_MESSAGE);
      }catch(InvalidGuitarPartException $e){
        echo json_encode(array("result"=>0,"message" => $e->getMessage()));
      }
    break;
    case AppCfg::ADD_SIGNATURE_ACTION:
      $objectGuitar = isset($_POST['guitar']) ? $_POST['guitar'] : null;
      if(!is_null($objectGuitar)){
        $guitarModel = new GuitarModel();
      }else
        echo AppCfg::NULL_PARAMETERS_FOUND;
    break;
    default:
      echo AppCfg::UNRECOGNIZED_ACTION;
  }
}else
  echo AppCfg::NULL_PARAMETERS_FOUND;

 ?>
