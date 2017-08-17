<?php

@session_start();

$raiz = $_SESSION['raiz'];

require_once $raiz.'/librerias/ConexionPDO.php';

class MGetListaCriterios{
    
    public static function getLista(){
        
        $sql = 'select id, des from get_listas_dimension() as ("id" integer, "des" varchar);';
        
        $con = new ConexionPDO();
        $con->conectar("PG");
        $res = $con->consultar($sql);
        $con->cerrarConexion();
        
        return $res;
        
    }
    
    public static function getCriterios($id){
        
        $sql = 'select id, pre, des from get_listas_criterios('.$id.') as ("id" integer, "pre" varchar, "des" varchar);';
        
        $con = new ConexionPDO();
        $con->conectar("PG");
        $res = $con->consultar($sql);
        $con->cerrarConexion();
        
        return $res;
        
    }
    
}

?>