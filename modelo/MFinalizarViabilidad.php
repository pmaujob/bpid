<?php

@session_start();

$raiz = $_SESSION['raiz'];

require_once $raiz . '/librerias/ConexionPDO.php';

class MFinalizarViabilidad {

    public static function registrarViabilidad($idRad,$responsables) {

        $sql = "select from ingresar_responsables_viabilidad($idRad,$responsables);";

        $con = new ConexionPDO();
        $con->conectar("PG");
        $res = $con->afectar($sql);
        $con->cerrarConexion();

        return $res;
        
    }

}

?>