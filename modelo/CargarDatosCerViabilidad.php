<?php

@session_start();
$raiz = $_SESSION['raiz'];
require_once '../../librerias/ConexionPDO.php';
require_once $raiz . '/librerias/SessionVars.php';

class CargarDatosCerViabilidad {

    public static function getDatosInformeViabilidad($idRad) {

        $consulta = "SELECT nb.numero_completo,"//0
                . "upper(r.nombre_proyecto),"//1
                . "r.entidad_proponente,"//2
                . "r.entidad_ejecutante,"//3
                . "lower(e.descripcion),"//4
                . "array_agg(distinct lower(p.descripcion)), "//5
                . "array_agg(distinct lower(s.descripcion)), "//6
                . "lower(r.problema),"//7
                . "lower(r.objetivo),"//8
                . "r.cod_bpid,"//9
                . "r.resumen,"//10
                . "r.poblacion,"//11
                . "r.localizacion,"//12
                . "r.cod_radicacion,"//13
                . "r.fecha_viabilidad,"//14
                . "r.hora_viabilidad "//15
                . "FROM radicacion AS r "
                . "INNER JOIN numero_bpid AS nb ON r.cod_bpid = nb.cod_numero_bpid "
                . "INNER JOIN radicacion_meta AS rm ON r.cod_radicacion = rm.cod_radicacion "
                . "INNER JOIN meta_producto AS mp ON mp.cod_meta_producto = rm.cod_meta_producto "
                . "INNER JOIN subprograma AS s ON mp.cod_subprograma = s.cod_subprograma "
                . "INNER JOIN programa AS p ON s.cod_programa = p.cod_programa "
                . "INNER JOIN eje AS e ON p.cod_eje = e.cod_eje "
                . "WHERE r.cod_radicacion = $idRad "
                . "GROUP BY nb.numero_completo,upper(r.nombre_proyecto),r.entidad_proponente,r.entidad_ejecutante,e.descripcion,r.problema,r.objetivo,r.cod_bpid,r.resumen,r.poblacion,r.localizacion,r.cod_radicacion,r.fecha_viabilidad;";

        return self::getDatos($consulta);
    }

    public static function getDatosInformeNoViabilidad($idRad) {

        $consulta = 'SELECT r.cod_radicacion,'//0
                . 'r.nombre_proyecto,'//1
                . 'r.fecha_envio,'//2
                . 'nb.numero_completo '//3
                . 'FROM radicacion AS r '
                . 'INNER JOIN numero_bpid AS nb ON r.cod_bpid = cod_numero_bpid '
                . 'WHERE r.cod_radicacion = ' . $idRad;

        return self::getDatos($consulta);
    }

    public static function getObjetivosEspecificos($codBpid) {

        $consulta = "SELECT o.id,"
                . "o.objetivo "
                . "FROM numero_bpid AS n "
                . "INNER JOIN radic_objespecificos AS o ON n.cod_numero_bpid = o.cod_bpid AND n.cod_numero_bpid = $codBpid";

        return self::getDatos($consulta);
    }

    public static function getProductos($codRadicacion) {

        $consulta = "SELECT id_producto,"//0
                . "nom_producto,"//1
                . "cantidad, "//2
                . "unidad "//3
                . "FROM radicacion_productos WHERE cod_radicacion = $codRadicacion;";

        return self::getDatos($consulta);
    }

    public static function getActividades($codProducto) {

        $consulta = "SELECT ra.id_actividad,"//0
                . "ra.valor,"//1
                . "ra.descripcion,"//2
                . "ra.cod_meta_producto,"//3
                . "mp.descripcion,"//4
                . "array_agg(nm.num_meta_producto) as nums "//5
                . "FROM radicacion_actividades AS ra "
                . "INNER JOIN meta_producto AS mp ON ra.cod_meta_producto = mp.cod_meta_producto "
                . "INNER JOIN num_meta_producto AS nm ON mp.cod_meta_producto = nm.cod_meta_producto "
                . "WHERE id_producto = $codProducto "
                . "GROUP BY ra.id_actividad,ra.valor,ra.descripcion,ra.cod_meta_producto,mp.descripcion;";

        return self::getDatos($consulta);
    }

    public static function getResponsables($codRadicacion) {

        $consulta = "SELECT idres,"//0
                . "nombres,"//1
                . "apellidos,"//2
                . "cargo "//3
                . "FROM radicacion_responsables WHERE cod_radicacion = $codRadicacion;";

        return self::getDatos($consulta);
    }

    public static function getObservaciones($idRad) {

        $consulta = "SELECT rdo.iddimobs,"//0
                . "rdo.observacion,"//1
                . "rdo.porcentaje,"//2
                . "vd.descripcion "//3
                . "FROM radicacion_dimensiones_observaciones AS rdo "
                . "INNER JOIN viabilidad_dimension AS vd ON rdo.id_dimen = vd.id_dimen "
                . "WHERE rdo.cod_radicacion = $idRad "
                . "AND rdo.porcentaje < 90;";

        return self::getDatos($consulta);
    }

    private static function getDatos($consulta) {
        
        $con = new ConexionPDO();
        $con->conectar("PG");
        $res = $con->consultar($consulta);
        $con->cerrarConexion();

        return $res;
    }

}

?>
