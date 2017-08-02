<?php

require_once '../../librerias/ConexionPDO.php';
  
class CargarViabilizados{

    public static function getViabilizados($datos,$op){
        
        $datos = "'".$datos."'";

        $consulta = 'select cod, '//0
                . 'num, '//1
                . 'nombre, '//2
                . 'abr, '//3
                . 'id, '//4
                . 'nump '//5
                . 'from get_radicados('.$datos.','.$op.') as ("cod" integer, "num" varchar, "nombre" varchar, "abr" varchar, "id" varchar, "nump" varchar);';

        $con = new ConexionPDO();
        $con->conectar("PG");
        $res = $con->consultar($consulta);
        $con->cerrarConexion();
        return $res;

    }

}

?>