<?php

class GuitarFreetboards{
  const EBONY = 1;
  const MAPLE = 2;
  const ROSEWOOD = 3;

  public static function isValidFreetboard($part){
    $isValid = null;
    switch($part){
      case EBONY:
      case MAPLE:
      case ROSEWOOD:
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
