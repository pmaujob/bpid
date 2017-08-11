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

    public static function guardarEnviarListas($idRad) {
        $sql = "select from guardar_enviar_listas($idRad);";

        $con = new ConexionPDO();
        $con->conectar("PG");
        $resultado = $con->afectar($sql);
        $con->cerrarConexion();

        return $resultado;
    }

    public static function getCorreoRad($idRad) {

        $sql = "SELECT correo_responsable FROM radicacion WHERE cod_radicacion = $idRad;";

        $con = new ConexionPDO();
        $con->conectar("PG");
        $resultado = $con->consultar($sql);
        $con->cerrarConexion();

        return $resultado;
        
    }

}
?>

