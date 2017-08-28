<?php

require_once '../librerias/ConexionPDO.php';

class MRegistrarDatosPrograma {

    public static function registrarDatosPrograma($codRadicacion, $codPrograma) {

        $sql = "INSERT INTO radicacion_programa(cod_radicacion, cod_programa) VALUES($codRadicacion,$codPrograma);";

        $con = new ConexionPDO();
        $con->conectar("PG");
        $resultado = $con->afectar($sql);
        $con->cerrarConexion();

        return $resultado;
    }

    public static function registrarDatosSubprograma($codRadicacion, $subprogramas) {

        $con = new ConexionPDO();
        $con->conectar("PG");

        for ($i = 0; $i < count($subprogramas); $i++) {
            $subprograma = $subprogramas[$i];
            $sql = "INSERT INTO radicacion_subprograma(cod_radicacion, cod_subprograma) VALUES($codRadicacion,$subprograma);";
            $resultado = $con->afectar($sql);
        }

        $con->cerrarConexion();

        return $resultado;
    }
    
    public static function registrarDatosMetas($codRadicacion, $metas) {

        $con = new ConexionPDO();
        $con->conectar("PG");

        for ($i = 0; $i < count($metas); $i++) {
            $meta = $metas[$i];
            $sql = "INSERT INTO radicacion_meta_producto(cod_radicacion, cod_meta_producto) VALUES($codRadicacion,$meta);";
            $resultado = $con->afectar($sql);
        }

        $con->cerrarConexion();

        return $resultado;
    }

    public static function ejecutarConsulta($sql) {

        $sql = "INSERT INTO radicacion_programa(cod_radicacion, cod_programa) VALUES($codRadicacion,$codPrograma);";

        $con = new ConexionPDO();
        $con->conectar("PG");
        $resultado = $con->afectar($sql);
        $con->cerrarConexion();

        return $resultado;
    }

}
?>

