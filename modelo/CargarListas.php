<?php

require_once 'ConexionPDO.php';

class CargarListas{
    
    public static function getListaGeneral(){
        
        $consulta = 'select cod, des, tipo from get_lista_general() as ("cod" integer, "des" varchar, "tipo" varchar);';
        
        $con = new ConexionPDO();
        $res = $con->consultar($consulta);
        $con->cerrarConexion();
        
        return $res;
        
    }
    
    public static function getRequisitos($fil,$cod){
        
        $consulta = 'select id, cod, des, estado from get_requisitos('.$fil.','.$cod.') as ("id" varchar, "cod" integer, "des" varchar, "estado" varchar);';
    
        $con = new ConexionPDO();
        $res = $con->consultar($consulta);
        $con->cerrarConexion();
        
        return $res;
        
    }
    
    public static function getSubRequisitos($fil,$cod){
        
        $consulta = 'select id, cod, des, estado from get_sub_requisitos('.$fil.','.$cod.') as ("id" varchar, "cod" integer, "des" varchar, "estado" varchar);';
        
        $con = new ConexionPDO();
        $res = $con->consultar($consulta);
        $con->cerrarConexion();
        
        return $res;
        
    }
    
}

?>

