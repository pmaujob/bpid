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
                . 'a, '//3
                . 'nomarc, '//4
                . 'obs '//5
                . 'from get_requisitos(' . $fil . ',' . $cod . ') as ("cod" integer, "des" varchar, "estado" varchar, "a" integer, "nomarc" varchar, "obs" varchar) order by cod;';

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
                . 'a, '//3
                . 'nomarc, '//4
                . 'obs '//5
                . 'from get_sub_requisitos('.$fil.','.$cod.') as ("cod" integer, "des" varchar, "estado" varchar, "a" integer, "nomarc" varchar, "obs" varchar) order by cod;';
        
        $con = new ConexionPDO();
        $con->conectar("PG");
        $res = $con->consultar($consulta);
        $con->cerrarConexion();

        return $res;
    }

}
?>

