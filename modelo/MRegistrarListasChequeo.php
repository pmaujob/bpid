<?php

require_once '../librerias/ConexionPDO.php';

class MRegistrarListasChequeo {

    public static function registrarListasChequeo($idRad, $reqJson, $subJson) {
        $sql = "select from ing_listas_chequeo($idRad," . $reqJson . "," . ($subJson == null ? "'null'" : $subJson) . ");";

        $con = new ConexionPDO();
        $con->conectar("PG");
        $resultado = $con->afectar($sql);
        $con->cerrarConexion();

        return $resultado;
    }

    public static function enviarAViabilidad($idRad) {

        $sql = "UPDATE radicacion SET cod_activacion = 2 WHERE cod_radicacion = " . $idRad;

        $con = new ConexionPDO();
        $con->conectar("PG");
        $resultado = $con->afectar($sql);
        $con->cerrarConexion();

        return $resultado;
        
    }

}
?>

