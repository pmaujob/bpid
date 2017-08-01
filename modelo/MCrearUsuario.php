<?php

@session_start();

$raiz = $_SESSION['raiz'];

require_once $raiz.'/librerias/ConexionPDO.php';

class MCrearUsuario{
    
    public static function crearUsuario($cedula,$nombre,$apellido,$correo,$dependencia,$clave,$permisos){
        
        $sql = "select from seguridad.crear_usuario('$cedula','$nombre','$apellido','$correo','$dependencia','$clave',$permisos);";
        
        $con = new ConexionPDO();
        $con->conectar("PG");
        $res = $con->afectar($sql);
        
        return $res;
        
    }
    
}

?>
