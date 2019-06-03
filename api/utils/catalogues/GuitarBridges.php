<?php

class GuitarBridges{
  const FLOYD_ROSE = 1;
  const TREMOLO_FULLCRUM = 2;
  const FLOYD_ROSE_HH = 3;

  public static function isValidBridge($part){
    $isValid = null;
    switch($part){
      case FLOYD_ROSE:
      case TREMOLO_FULLCRUM:
      case FLOYD_ROSE_HH:
        $isValid = true;
      default:
        $isValid = false;
    }
    return $isValid;
  }
}
 ?>
