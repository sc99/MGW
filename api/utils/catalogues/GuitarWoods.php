<?php

class GuitarWoods{
  const ASH = 1;
  const ALDER = 2;
  const KOA = 3;

  public static function isValidWood($part){
    $isValid = null;
    switch($part){
      case ASH:
      case ALDER:
      case KOA:
        $isValid = true;
      default:
        $isValid = false;
    }
    return $isValid;
  }
}

 ?>
