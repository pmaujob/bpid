<?php

require_once '../../librerias/ConexionPDO.php';

class CargarListas {

    public static function getListaGeneral($requerido) {

        $consulta = 'select cod, '
                . 'des, '
                . 'tipo from get_lista_general(' . $requerido . ') as ("cod" integer, "des" varchar, "tipo" varchar);';

        $con = new ConexionPDO();
        $con->conectar("PG");
        $res = $con->consultar($consulta);
        $con->cerrarConexion();

        return $res;
    }

    public static function getRequisitos($fil, $cod) {// fil -> cod_radicacion

        $consulta = 'select cod, '//0
                . 'des, '//1
                . 'estado, '//2
                . 'nomarc, '//3
                . 'obs '//4
                . 'from get_requisitos(' . $fil . ',' . $cod . ') as ("cod" integer, "des" varchar, "estado" varchar, "nomarc" varchar, "obs" varchar) order by cod;';

        $con = new ConexionPDO();
        $con->conectar("PG");
        $res = $con->consultar($consulta);
        $con->cerrarConexion();

        return $res;
    }

    public static function getSubRequisitos($fil, $cod) {

        $consulta = 'select cod, '//0
                . 'des, '//1
                . 'estado, '//2
                . 'nomarc, '//3
                . 'obs '//4
                . 'from get_sub_requisitos('.$fil.','.$cod.') as ("cod" integer, "des" varchar, "estado" varchar, "nomarc" varchar, "obs" varchar) order by cod;';
        
        $con = new ConexionPDO();
        $con->conectar("PG");
        $res = $con->consultar($consulta);
        $con->cerrarConexion();

        return $res;
    }
    public static function getListaMedidas(){

        $consulta = 'select id, '//0
                . 'abr, '//1
                . 'des  '//2
                . 'from get_unidades_medida() as ("id" integer, "abr" varchar, "des" varchar);';
        
        $con = new ConexionPDO();
        $con->conectar("PG");
        $res = $con->consultar($consulta);
        $con->cerrarConexion();

        return $res;
    }

}
?>

