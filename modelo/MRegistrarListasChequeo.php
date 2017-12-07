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

        $sql = 'select correo, '//0
                . 'nomres, '//1
                . 'nompro, '//2
                . 'numpro '//3
                . 'from get_correo_rad('.$idRad.') as ("correo" varchar, "nomres" varchar, "nompro" varchar, "numpro" varchar);';

        $con = new ConexionPDO();
        $con->conectar("PG");
        $resultado = $con->consultar($sql);
        $con->cerrarConexion();

        return $resultado;
        
    }

}
?>

