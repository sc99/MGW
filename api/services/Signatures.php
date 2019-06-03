<?php
require_once("../settings/AppCfg.php");
require_once("../models/GuitarModel.php");
require_once("../models/OrderModel.php");

$action = isset($_POST['action']) ? $_POST['action'] : null;

if(!is_null($action)){
  switch($action){
    case AppCfg::DELETE_SIGNATURE_ACTION:
      $signature = isset($_POST['signature']) ? $_POST['signature'] : null;
      if(!is_null($signature)){
        $guitarModel = new GuitarModel();
        $guitarModel = $guitarModel->deleteGuitar($signature);
        echo $guitarModel;
      }else
        echo AppCfg::NULL_PARAMETERS_FOUND;
    break;
    case AppCfg::ORDER_SIGNATURE_ACTION:
      $order = isset($_POST['order']) ? json_decode($_POST['order'],true) : null;
      if(!is_null($order)){
          $orderModel = new OrderModel();
          $orderModel = $orderModel->addOrder($order['name'],$order['surname'],$order['lastname'],$order['card'],$order['ccv'],$order['signature']);
          echo $orderModel;
      }else
        echo AppCfg::NULL_PARAMETERS_FOUND;
    break;
    case AppCfg::ALL_SIGNATURES_ACTION:
    case AppCfg::GET_ALTER_SIGNATURES_ACTION:
      $guitarModel = new GuitarModel();
      try{
          $guitarModel = $guitarModel->getAllGuitars();
          if(!is_null($guitarModel)){
            $response = $guitarModel;
          //  var_dump($response);
            $response =  json_encode(array("result" => 1,"guitars"=>$guitarModel));
            echo $response;
          }else
              echo json_encode(array("result"=>-1,"message" => AppCfg::NO_SIGNATURES_MESSAGE));
      }catch(InvalidGuitarPartException $e){
        echo json_encode(array("result"=>0,"message" => $e->getMessage()));
      }
    break;
    case AppCfg::ADD_SIGNATURE_ACTION:
      $objectGuitar = isset($_POST['signature']) ? json_decode($_POST['signature'],true) : null;
      if(!is_null($objectGuitar)){
        $guitarModel = new GuitarModel();
        echo $guitarModel->addGuitar($objectGuitar['model'],$objectGuitar['kaoss'],$objectGuitar['sustainer'],$objectGuitar['price'],
        $objectGuitar['body'],$objectGuitar['freet'],$objectGuitar['bridge'],$objectGuitar['picks'],
        $objectGuitar['strings'],$objectGuitar['effect'],$objectGuitar['wood']);
      }else
        echo AppCfg::NULL_PARAMETERS_FOUND;
    break;
    case AppCfg::GET_SIGNATURE_PARTS_ACTION:
          $guitarModel = new GuitarModel();
          echo $guitarModel->getGuitarParts();
    break;
    default:
      echo AppCfg::UNRECOGNIZED_ACTION;
  }
}else
  echo AppCfg::NULL_PARAMETERS_FOUND;

 ?>
