<?php

class GuitarBodies{
  const HOLLOW = 1;
  const SEMI_HOLLOW = 2;
  const SOLID = 3;

  public static function isValidBody($part){
    $isValid = null;
    switch($part){
      case HOLLOW:
      case SEMI_HOLLOW:
      case SOLID:
        $isValid = true;
      break;
      default:
        $isValid = false;
        break;
    }
    return $isValid;
  }
}
 ?>
