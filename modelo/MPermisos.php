<?php

require_once '../librerias/ConexionPDO.php';

class MPermisos{
    
    public static function tienePermiso($cedula,$id){
        
        $sql = 'select cont from seguridad.get_permiso('.$cedula.','.$id.') as ("cont" varchar);';
        
        $con = new ConexionPDO();
        $con->conectar("PG");
        $res = $con->consultar($sql);
        $permiso = false;
        
        while($resultado = $res->fetch(PDO::FETCH_OBJ))
            $permiso = ($resultado->cont)==="Ok" ? true : false;

        return $permiso;
        
    }
    
}

?>
