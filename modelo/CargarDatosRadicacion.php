<?php

require_once '../../librerias/ConexionPDO.php';

class CargarDatosRadicacion {
    
    public static function getDatosListas($idRad, $tipo) {//tipo principal o sub
        $sql = 'select cod, '//0
                . 'des '//1
                . 'from get_datos_lista_general(' . $idRad . ",'" . $tipo . "') "
                . 'as ("cod" integer, "des" varchar);';

        $con = new ConexionPDO();
        $con->conectar("PG");
        $res = $con->consultar($sql);
        $con->cerrarConexion();

        return $res;
         
    }

    public static function getDatosRequisitos($idRad, $codList) {
        $sql = 'select cod, '//0
                . 'des, '//1
                . 'estado, '//2
                . 'nomarc, '//3
                . 'obs '//4
                . 'from get_datos_requisitos(' . $idRad . ',' . $codList . ") "
                . 'as ("cod" integer, "des" varchar, "estado" varchar, "nomarc" varchar, "obs" varchar);';

        $con = new ConexionPDO();
        $con->conectar("PG");
        $res = $con->consultar($sql);
        $con->cerrarConexion();

        return $res;
    }

    public static function getDatosSubrequisitos($idRad, $codReq, $tipo) {

        if ($tipo == 0) {
            $sql = 'select cod, '//0
                    . 'des '//1
                    . 'from get_datos_sub_requisitos('.$idRad.', null, 0) '
                    . 'as ("cod" integer, "des" varchar);';
        } else {
            $sql = 'select cod, '//0
                    . 'des, '//1
                    . 'estado, '//2
                    . 'nomarc, '//4
                    . 'obs '//5
                    . 'from get_datos_sub_requisitos('.$idRad.','.$codReq.', 1) '
                    . 'as ("cod" integer, "des" varchar, "estado" varchar, "nomarc" varchar, "obs" varchar);';
        
        }

        $con = new ConexionPDO();
        $con->conectar("PG");
        $res = $con->consultar($sql);
        $con->cerrarConexion();

        return $res;
    }

}

?>
