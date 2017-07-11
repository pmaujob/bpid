<?php

require_once '../../librerias/ConexionPDO.php';
    
class CargarRadicados{

    public static function getRadicados($datos){
        
        $datos = "'".$datos."'";

        $consulta = 'select cod, num, nombre, abr, id from get_radicados('.$datos.') as ("cod" integer, "num" varchar, "nombre" varchar, "abr" varchar, "id" varchar);';

        $con = new ConexionPDO();
        $con->conectar("PG");
        $res = $con->consultar($consulta);
        $con->cerrarConexion();
        return $res;

    }

}

?>