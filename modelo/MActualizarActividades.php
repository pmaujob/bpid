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

}

?>