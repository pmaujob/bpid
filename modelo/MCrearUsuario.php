<?php

@session_start();

$raiz = $_SESSION['raiz'];

require_once $raiz.'librerias/ConexionPDO.php';

class MCrearUsuario{
    
    public static function crearUsuario($cedula,$nombre,$apellido,$correo,$dependencia){
        
        $sql = "";
        
        $con = new ConexionPDO();
        $con->conectar("PG");
        $res = $con->consultar($sql);
        
    }
    
}

?>
