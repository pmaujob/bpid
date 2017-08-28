<?php

@session_start();

$raiz = $_SESSION['raiz'];

require_once $raiz.'/librerias/ConexionPDO.php';

class MActualizarUsuario{
    
    public static function setPermiso($cedula,$estado){
        
        $sql = "select from seguridad.set_estado_usuario('$cedula',$estado);";
        
        $con = new ConexionPDO();
        $con->conectar("PG");
        $res = $con->afectar($sql);
        $con->cerrarConexion();
        
        return $sql;
        
    }
    
    public static function actualizarPermisos($cedula,$permisos){
        
        $sql = "select from seguridad.actualizar_permisos_usuarios('$cedula',$permisos);";
        
        $con = new ConexionPDO();
        $con->conectar("PG");
        $res = $con->consultar($sql);
        $con->cerrarConexion();
        
        return $res;
        
    }
    
}

?>

