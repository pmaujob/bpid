<?php

@session_start();

$raiz = $_SESSION['raiz'];

require_once $raiz . '/librerias/ConexionPDO.php';

class MRegistrarCriterios {

    public static function registrarCriterios($idRadicacion, $preguntas, $observaciones) {

        $sql = "select from ing_criterios_viabilidad($idRadicacion,$preguntas,$observaciones);";

//        $con = new ConexionPDO();
//        $con->conectar("PG");
//        $res = $con->afectar($sql);
//        $con->cerrarConexion();

        return $sql;
    }

}

?>
