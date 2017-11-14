<?php

@session_start();

$raiz = $_SESSION['raiz'];

require_once $raiz . '/librerias/ConexionPDO.php';

class MDatosRegistro {

    public static function getDatosRegistro($idRad) {

        $sql = 'select nump, fece, fecf, noms, nomp, epro, eejec from get_datos_rad_registro(' . $idRad . ') as ("nump" varchar, "fece" varchar, "fecf" varchar, "noms" varchar, "nomp" varchar, "epro" varchar, "eejec" varchar);';

        $con = new ConexionPDO();
        $con->conectar("PG");
        $res = $con->consultar($sql);
        $con->cerrarConexion();

        return $res;
    }
    
    public static function getDatosFirmas(){
        
        $sql = 'select id, des from get_datos_firmas() as("id" integer, "des" varchar);';
        
        $con = new ConexionPDO();
        $con->conectar("PG");
        $res = $con->consultar($sql);
        $con->cerrarConexion();
        
        return $res;
        
    }

}
?>

