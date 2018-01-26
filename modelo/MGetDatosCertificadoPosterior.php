<?php

@session_start();

$raiz = $_SESSION['raiz'];

require_once $raiz . '/librerias/ConexionPDO.php';
require_once $raiz . '/librerias/SessionVars.php';

class MGetDatosCertificadoPosterior {

    public static function getDatos($idRad) {

        $sql = 'select num, fece, fvia, tip, sec, nomfir, nom, enti, ente, mot, contr, arch, val from get_datos_control_posterior(' . $idRad . ') as ("num" varchar, "fece" varchar, "fvia" varchar, "tip" varchar, "sec" varchar, "nomfir" varchar, "nom" varchar, "enti" varchar, "ente" varchar, "mot" varchar, "contr" varchar, "arch" varchar, "val" varchar);';

        $con = new ConexionPDO();
        $con->conectar("PG");
        $res = $con->consultar($sql);
        $con->cerrarConexion();

        return $res;
        
    }

}

?>