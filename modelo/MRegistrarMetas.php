<?php

require_once '../librerias/ConexionPDO.php';

class MRegistrarMetas {

    public static function registrarMetas($codRadicacion, $metas) {

        $sql = "select from ingresar_metas_radicacion($codRadicacion,$metas);";

        $con = new ConexionPDO();
        $con->conectar("PG");
        $resultado = $con->afectar($sql);
        $con->cerrarConexion();

        return $resultado;
    }

}



?>

