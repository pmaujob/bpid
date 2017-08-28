<?php

@session_start();

$raiz = $_SESSION['raiz'];

require_once $raiz.'/librerias/ConexionPDO.php';

class MModuloConFunciones{
    
    public static function getFunciones(){
        
        $sql = 'select id, mod, fun from seguridad.get_modulos_funciones() as ("id" integer, "mod" varchar, "fun" varchar);';
        
        $con = new ConexionPDO();
        $con->conectar("PG");
        return $con->consultar($sql);
        
    }
    
    public static function getFuncionesUser($cedula){
        
        $cedula = "'".$cedula."'";
        
        $sql = 'select id, mod, fun, ced from seguridad.get_modulos_funciones_usuarios('.$cedula.') as ("id" integer, "mod" varchar, "fun" varchar, "ced" varchar);';
        
        $con = new ConexionPDO();
        $con->conectar("PG");
        $res = $con->consultar($sql);
        $con->cerrarConexion();
        
        return $res;
        
    }
    
}

?>

