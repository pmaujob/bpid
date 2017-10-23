<?php

require_once '../librerias/ConexionPDO.php';

class MRollBack {

    public static function returnToMetas($idRad) {

        $consult = "UPDATE radicacion SET cod_activacion = 2 WHERE cod_radicacion = $idRad;";

        $con = new ConexionPDO();
        $con->conectar("PG");
        $resultado = $con->afectar($consult);
        $con->cerrarConexion();

        return $resultado;
    }

}
?>

