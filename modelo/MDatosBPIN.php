<?php

@session_start();

$raiz = $_SESSION['raiz'];

require_once $raiz . '/librerias/ConexionPDO.php';

class MGetDatosBPIN {

    public static function getDatosRadicacionBPIN($idRad) {

        $sql = 'select num, nom from get_datos_bpin(' . $idRad . ') as ("num" varchar, "nom" varchar);';

        $con = new ConexionPDO();
        $con->conectar("PG");
        $res = $con->consultar($sql);
        $con->cerrarConexion();

        return $res;
    }

    public static function registrarCodigoBPIN($idRad, $codBPIN) {

        $sql = "select from ing_cod_bpin($idRad,'".$codBPIN."');";

        $con = new ConexionPDO();
        $con->conectar("PG");
        $res = $con->afectar($sql);
        $con->cerrarConexion();

        return $res;
    }

}
