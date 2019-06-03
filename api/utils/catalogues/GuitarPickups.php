<?php

class GuitarPickups{
  const SSS = 1;
  const HH = 2;
  const SHS = 3;
  const HSS = 4;
  const HHH = 5;
  const S = 6;
  const SS = 7;

  public static function isValidPickup($part){
    $isValid = null;
    switch($part){
      case SSS:
      case HH:
      case SHS:
      case HSS:
      case HHH:
      case S:
      case SS:
        $isValid = true;
      default:
        $isValid = false;
    }
    return $isValid;
  }
}
 ?>
