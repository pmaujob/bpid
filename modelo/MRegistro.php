<?php

@session_start();

$raiz = $_SESSION['raiz'];

require_once $raiz . '/librerias/ConexionPDO.php';

class MRegistro {

    public static function registrar($tipoReg, $conceptoPost, $motivacion, $archivo, $archivoHash, $idRad, $secretario) {

        $sql = "select from ing_registro('$tipoReg','$conceptoPost','$motivacion','$archivo','$archivoHash','$idRad',$secretario);";

        $con = new ConexionPDO();
        $con->conectar("PG");
        $res = $con->afectar($sql);

        return $res;
        
    }

}
