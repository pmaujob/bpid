<?php

@session_start();
$raiz = $_SESSION['raiz'];
require_once '../../librerias/ConexionPDO.php';
require_once $raiz . '/librerias/SessionVars.php';

class CargarDatosCerViabilidad {

    public static function getDatosInformeViabilidad($filtro) {

        $sess = new SessionVars();
        $sess->init();
        $codSecretaria = $sess->getValue('idSec');
        $cedula = $sess->getValue('cedula');

        $consulta = "SELECT nb.numero_completo,"//0
                . "upper(r.nombre_proyecto),"//1
                . "r.entidad_proponente,"//2
                . "r.entidad_ejecutante,"//3
                . "lower(e.descripcion),"//4
                . "array_agg(distinct lower(p.descripcion)), "//5
                . "array_agg(distinct lower(s.descripcion)) "//6
                . "FROM radicacion AS r "
                . "INNER JOIN numero_bpid AS nb ON r.cod_bpid = nb.cod_numero_bpid "
                . "INNER JOIN radicacion_meta AS rm ON r.cod_radicacion = rm.cod_radicacion "
                . "INNER JOIN meta_producto AS mp ON mp.cod_meta_producto = rm.cod_meta_producto "
                . "INNER JOIN subprograma AS s ON mp.cod_subprograma = s.cod_subprograma "
                . "INNER JOIN programa AS p ON s.cod_programa = p.cod_programa "
                . "INNER JOIN eje AS e ON p.cod_eje = e.cod_eje "
                . "WHERE nb.numero_completo like '%0%' "
                . "GROUP BY nb.numero_completo,upper(r.nombre_proyecto),r.entidad_proponente,r.entidad_ejecutante,e.descripcion;";
        $con = new ConexionPDO();
        $con->conectar("PG");
        $res = $con->consultar($consulta);
        $con->cerrarConexion();

        return $res;
    }

}

?>
