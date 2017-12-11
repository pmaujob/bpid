<?php

@session_start();

$raiz = $_SESSION['raiz'];

require_once $raiz . '/librerias/ConexionPDO.php';
require_once $raiz . '/modelo/MRegistrarResponsableEtapa.php';

class MRegistrarCriterios {

    public static function registrarCriterios($idRadicacion, $preguntas, $observaciones, $op) {
        
        MRegistrarResponsableEtapa::registrarResponsableEtapa($idRadicacion, 5);

        $sql = "select from ing_criterios_viabilidad($idRadicacion,$preguntas,$observaciones,$op);";

        $con = new ConexionPDO();
        $con->conectar("PG");
        $res = $con->afectar($sql);
        $con->cerrarConexion();

        return $res;
    }

}

?>
