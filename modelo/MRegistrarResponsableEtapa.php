<?php

@session_start();

$raiz = $_SESSION['raiz'];

require_once $raiz . '/librerias/ConexionPDO.php';
require_once $raiz . '/librerias/SessionVars.php';

class MRegistrarResponsableEtapa {

    public static function registrarResponsableEtapa($idRad, $codAct) {

        $sess = new SessionVars();
        $cedula = "'" . $sess->getValue('cedula') . "'";

        $sql = "select from ing_responsables($idRad,$codAct,$cedula);";

        $con = new ConexionPDO();
        $con->conectar("PG");
        $res = $con->afectar($sql);

        return $res;
    }

    public static function getResponsableEtapa($idRad, $pcodact) {

        $sess = new SessionVars();
        $cedula = "'" . $sess->getValue('cedula') . "'";

        $sql = 'select nombre from get_responsable_etapa('.$idRad.','.$pcodact.') as ("nombre" varchar);';

        $con = new ConexionPDO();
        $con->conectar("PG");
        $res = $con->consultar($sql);

        return $res;
    }

}

?>
