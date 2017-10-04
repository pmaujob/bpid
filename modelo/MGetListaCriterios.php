<?php

@session_start();

$raiz = $_SESSION['raiz'];

require_once $raiz.'/librerias/ConexionPDO.php';

class MGetListaCriterios{
    
    public static function getLista($idRad){
        
        $sql = 'select id, des, obs from get_listas_dimension('.$idRad.') as ("id" integer, "des" varchar, "obs" varchar);';
        
        $con = new ConexionPDO();
        $con->conectar("PG");
        $res = $con->consultar($sql);
        $con->cerrarConexion();
        
        return $res;
        
    }
    
    public static function getCriterios($id,$idRad){
        
        $sql = 'select id, pre, des from get_listas_criterios('.$idRad.','.$id.') as ("id" integer, "pre" varchar, "des" varchar);';
        
        $con = new ConexionPDO();
        $con->conectar("PG");
        $res = $con->consultar($sql);
        $con->cerrarConexion();
        
        return $res;
        
    }
    
}

?>