<?php

@session_start();

$raiz = $_SESSION['raiz'];

require_once $raiz . '/librerias/ConexionPDO.php';
require_once $raiz . '/modelo/MRegistrarResponsableEtapa.php';

class MFinalizarViabilidad {

    public static function registrarViabilidad($idRad, $responsables, $estado) {

        MRegistrarResponsableEtapa::registrarResponsableEtapa($idRad, 6);

        $sql = "select from ingresar_responsables_viabilidad($idRad,$responsables,$estado);";

        $con = new ConexionPDO();
        $con->conectar("PG");
        $res = $con->afectar($sql);
        $con->cerrarConexion();

        return $res;
    }

    public static function getDatosUsuario($idRad) {

        $sql = 'select nom, correo from get_correo_responsable(' . $idRad . ') as ("nom" varchar,"correo" varchar);';

        $con = new ConexionPDO();
        $con->conectar("PG");
        $res = $con->consultar($sql);
        $con->cerrarConexion();

        return $res;
    }

    public static function getCorreosRegistro() {

        $idFun = 13;
        $codSec = 37;

        $sql = 'select correo from get_correos_registro(' . $idFun . ', ' . $codSec . ') as ("correo" varchar);';

        $con = new ConexionPDO();
        $con->conectar("PG");
        $res = $con->consultar($sql);
        $con->cerrarConexion();

        return $res;
    }

}

?>