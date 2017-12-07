<?php

@session_start();

$raiz = $_SESSION['raiz'];

require_once $raiz . '/librerias/ConexionPDO.php';

class MGetDatosViabilidad {

    public static function getDatosViabilidad($idRad) {

        $sql = 'select obs, des, por, por2 from get_datos_viabilidad_responsables('.$idRad.') as ("obs" varchar, "des" varchar, "por" varchar, "por2" numeric);';

        $con = new ConexionPDO();
        $con->conectar("PG");
        $res = $con->consultar($sql);
        $con->cerrarConexion();

        return $res;
        
    }

}
?>

