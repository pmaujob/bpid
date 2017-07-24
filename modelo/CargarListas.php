<?php

require_once '../../librerias/ConexionPDO.php';

class CargarListas {

    public static function getListaGeneral($requerido) {

        $consulta = 'select cod, des, tipo from get_lista_general(' . $requerido . ') as ("cod" integer, "des" varchar, "tipo" varchar);';

        $con = new ConexionPDO();
        $con->conectar("PG");
        $res = $con->consultar($consulta);
        $con->cerrarConexion();

        return $res;
    }

    public static function getRequisitos($fil, $cod) {

        $consulta = 'select cod, des, estado, a from get_requisitos(' . $fil . ',' . $cod . ') as ("cod" integer, "des" varchar, "estado" varchar, "a" integer) order by cod;';

        $con = new ConexionPDO();
        $con->conectar("PG");
        $res = $con->consultar($consulta);
        $con->cerrarConexion();

        return $res;
    }

    public static function getSubRequisitos($fil, $cod) {

        $consulta = 'select cod, des, estado, a from get_sub_requisitos('.$fil.','.$cod.') as ("cod" integer, "des" varchar, "estado" varchar, "a" integer) order by cod;';
        $con = new ConexionPDO();
        $con->conectar("PG");
        $res = $con->consultar($consulta);
        $con->cerrarConexion();

        return $res;
    }

}
?>

