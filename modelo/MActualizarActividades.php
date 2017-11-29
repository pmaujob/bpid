<?php

require_once '../librerias/ConexionPDO.php';

class MActualizarActividades {

    public static function actualizarActividades($idRad, $datosActividades) {

        $sql = "select from ing_meta_actividad($idRad,$datosActividades);";

        $con = new ConexionPDO();
        $con->conectar("PG");
        $resultado = $con->afectar($sql);
        $con->cerrarConexion();

        return $resultado;
    }
    public static function actualizarUnidades($datosUnidades) {

        $sql = "select from act_producto_unidad($datosUnidades);";

        $con = new ConexionPDO();
        $con->conectar("PG");
        $resultado = $con->afectar($sql);
        $con->cerrarConexion();

        return $resultado;
    }

}

?>