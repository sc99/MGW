<?php

class GuitarStrings{
  const SIX_GAGUGE_EIGHT = 1;
  const SIX_GAUGE_NINE = 2;
  const SIX_GAUGE_TEN = 3;
  const SEVEN_GAUGE_TEN = 4;
  const SEVEN_GAUGE_ELEVEN = 5;
  const SEVEN_GAUGE_TWELVE = 6;

  public static function isValidString($part){
    $isValid = null;
    switch($part){
      case SIX_GAGUGE_EIGHT :
      case SIX_GAUGE_NINE:
      case SIX_GAUGE_TEN:
      case SEVEN_GAUGE_TEN :
      case SEVEN_GAUGE_ELEVEN:
      case SEVEN_GAUGE_TWELVE :
        $isValid = true;
      default:
        $isValid = false;
    }
    return $isValid;
  }

}

 ?>
