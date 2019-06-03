<?php

class AppCfg {

    const DB_HOST = "127.0.0.1:3306";
    const DB_USER = "root";
    const DB_PASS = "n0m3l0";
    const DB_NAME =  "mgw";
    const LOG_OUT_ACTION = "LOG_OUT";
    const LOG_IN_ACTION = "LOG_IN";
    const ALL_SIGNATURES_ACTION = "GET_ALL_SIGNATURES";
    const ADD_SIGNATURE_ACTION = "ADD_SIGNATURE";

    const NULL_PARAMETERS_FOUND = "La operación no puede ser completada con éxito debido a problemas con los parámetros enviados.";
    const UNRECOGNIZED_ACTION = "La acción que ha solicitado no se encuentra disponible.";
    const INVALID_GUITAR_PART = "La siguiente parte de guitarra contiene un valor no válido: ";
    const NO_SIGNATURES_MESSAGE = "Por el momento no tenemos guitarras en inventario.";
}

 ?>
