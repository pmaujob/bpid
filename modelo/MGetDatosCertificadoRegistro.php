<?php

@session_start();

$raiz = $_SESSION['raiz'];

require_once $raiz . '/librerias/ConexionPDO.php';

class MGetDatosCertificadoRegistro {

    public static function getDatosFuentesFinanciazion($idRad) {

        $sql = 'select origen, valor, tip, noment from get_datos_fuentes(' . $idRad . ') as ("origen" varchar, "valor" numeric, "tip" varchar, "noment" varchar);';

        $con = new ConexionPDO();
        $con->conectar("PG");
        $res = $con->consultar($sql);

        return $res;
    }

    public static function getDatosProEjeSub($idRad) {

        $sql = 'select cod, eje, pro, sub from get_datos_proejesub(' . $idRad . ') as ("cod" integer, "eje" varchar, "pro" varchar, "sub" varchar);';

        $con = new ConexionPDO();
        $con->conectar("PG");
        $res = $con->consultar($sql);

        return $res;
    }

    public static function getSecretarios($idRad) {

        $sql = 'select nom, cargo from get_secretarios('.$idRad.') as ("nom" varchar, "cargo" varchar);';

        $con = new ConexionPDO();
        $con->conectar("PG");
        $res = $con->consultar($sql);

        return $res;
    }

}

?>
