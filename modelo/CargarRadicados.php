<?php

@session_start();
$raiz = $_SESSION['raiz'];
require_once $raiz . '/librerias/ConexionPDO.php';
require_once $raiz . '/librerias/SessionVars.php';

class CargarRadicados {

    public static function getRadicados($datos, $op) {

        $sess = new SessionVars();
        $sess->init();
        $codSecretaria = $sess->getValue('idSec');
        $cedula = $sess->getValue('cedula');
        $datos = "'" . $datos . "'";

        $consulta = 'select cod, '//0
                . 'num, '//1
                . 'nombre, '//2
                . 'abr, '//3
                . 'id, '//4
                . 'nump, '//5
                . 'epro ' //6
                . 'from get_radicados(' . $datos . ',' . $op . ',' . (!empty($codSecretaria) ? $codSecretaria : "null") . ",'" . $cedula . '\') as ("cod" integer, "num" varchar, "nombre" varchar, "abr" varchar, "id" varchar, "nump" varchar, "epro" varchar);';

        $con = new ConexionPDO();
        $con->conectar("PG");
        $res = $con->consultar($consulta);
        $con->cerrarConexion();

        return $res;
    }

    public static function getDatosProyecto($idRad) {

        $consulta = 'select r.cod_radicacion,'//0
                . 'n.numero_completo,'//1
                . 'r.num_proyecto,'//2
                . 'r.nombre_proyecto '//3
                . 'from radicacion as r '
                . 'inner join numero_bpid as n on r.cod_bpid = n.cod_numero_bpid '
                . 'where r.cod_radicacion = ' . $idRad;

        $con = new ConexionPDO();
        $con->conectar("PG");
        $res = $con->consultar($consulta);
        $con->cerrarConexion();

        return $res;
    }

}

?>