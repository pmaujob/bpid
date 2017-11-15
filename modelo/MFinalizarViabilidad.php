<?php

@session_start();

$raiz = $_SESSION['raiz'];

require_once $raiz . '/librerias/ConexionPDO.php';

class MFinalizarViabilidad {

    public static function registrarViabilidad($idRad, $responsables, $estado) {

        $sql = "select from ingresar_responsables_viabilidad($idRad,$responsables,$estado);";

        $con = new ConexionPDO();
        $con->conectar("PG");
        $res = $con->afectar($sql);
        $con->cerrarConexion();

        return $res;
    }

    public static function getDatosUsuario($idRad) {

        $sql = 'select correo from get_correo_responsable(' . $idRad . ') as ("correo" varchar);';

        $con = new ConexionPDO();
        $con->conectar("PG");
        $res = $con->consultar($sql);
        $con->cerrarConexion();

        return $res;
    }

}

?>