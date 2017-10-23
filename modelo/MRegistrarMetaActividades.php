<?php

class MRegistrarMetaActividades {
    
    public static function actualizarActividades($metaActividades) {
        
        $sql = "UPDATE radicacion_actividades SET cod_meta_producto = $metaActividades[0] WHERE id_actividad = $metaActividades[1]";

        $con = new ConexionPDO();
        $con->conectar("PG");
        $resultado = $con->afectar($sql);
        $con->cerrarConexion();

        return $resultado;
        
    }
    
}



?>

