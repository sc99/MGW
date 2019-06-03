<?php

class GuitarEffects{

  const N_A = 1;
  const FUZZ = 2;
  const DELAY = 3;
  const CHORUS = 4;
  const FLANGER = 5;


  public static function isValidEffect($part){
    $isValid = null;
    switch($part){
      case N_A:
      case FUZZ:
      case DELAY:
      case CHORUS:
      case FLANGER:
        $isValid = true;
      default:
        $isValid = false;
    }
    return $isValid;
  }
}
 ?>
