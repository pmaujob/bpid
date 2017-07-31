<?php

@session_start();

$raiz = $_SESSION['raiz'];

require_once $raiz.'/librerias/ConexionPDO.php';

class MModuloConFunciones{
    
    public static function getFunciones(){
        
        $sql = 'select id, mod, fun from get_modulos_funciones() as ("id" integer, "mod" varchar, "fun" varchar);';
        
        $con = new ConexionPDO();
        $con->conectar("PG");
        return $con->consultar($sql);
        
    }
    
}

?>

