<?php

@session_start();

$raiz = $_SESSION['raiz'];

require_once $raiz . '/librerias/ConexionPDO.php';
require_once $raiz . '/modelo/MRegistrarResponsableEtapa.php';

class MRegistro {

    public static function registrar($tipoReg, $conceptoPost, $motivacion, $archivo, $archivoHash, $idRad, $secretario) {

        MRegistrarResponsableEtapa::registrarResponsableEtapa($idRad, 7);
        
        $sql = "select from ing_registro('$tipoReg','$conceptoPost','$motivacion','$archivo','$archivoHash','$idRad',$secretario);";

        $con = new ConexionPDO();
        $con->conectar("PG");
        $res = $con->afectar($sql);

        return $res;
    }

}
