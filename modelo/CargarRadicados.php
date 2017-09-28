<?php

session_start();
$raiz = $_SESSION['raiz'];
require_once '../../librerias/ConexionPDO.php';
require_once $raiz . '/librerias/SessionVars.php';

class CargarRadicados {

    public static function getRadicados($datos, $op) {

        $sess = new SessionVars();
        $sess->init();
        $codSecretaria = $sess->getValue('idSec');
        $datos = "'" . $datos . "'";

        $consulta = 'select cod, '//0
                . 'num, '//1
                . 'nombre, '//2
                . 'abr, '//3
                . 'id, '//4
                . 'nump '//5
                . 'from get_radicados(' . $datos . ',' . $op . ',' . $codSecretaria . ') as ("cod" integer, "num" varchar, "nombre" varchar, "abr" varchar, "id" varchar, "nump" varchar);';

        $con = new ConexionPDO();
        $con->conectar("PG");
        $res = $con->consultar($consulta);
        $con->cerrarConexion();
        return $res;
    }

}

?>