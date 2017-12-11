<?php

@session_start();

$raiz = $_SESSION['raiz'];

require_once $raiz . '/librerias/ConexionPDO.php';
require_once $raiz . '/modelo/MRegistrarResponsableEtapa.php';

class MRegistrarMetas {

    public static function registrarMetas($codRadicacion, $metas) {
        
        MRegistrarResponsableEtapa::registrarResponsableEtapa($codRadicacion, 3);

        $sql = "select from ingresar_metas_radicacion($codRadicacion,$metas);";

        $con = new ConexionPDO();
        $con->conectar("PG");
        $resultado = $con->afectar($sql);
        $con->cerrarConexion();

        return $resultado;
    }

}
?>

