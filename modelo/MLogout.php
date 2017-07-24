<?php

/**
 * Description of MLogout
 *
 * @author MAURICIO
 */
require_once '../librerias/ConexionPDO.php';

class MLogout {
    
    public static function logOut($idLog){
        
        $sql = 'select from seguridad.log_out('.$idLog.');';
        
        $con = new ConexionPDO();
        $con->conectar("PG");
        $con->consultar($sql);
        
        $con->cerrarConexion();
        
    }
    
}

?>
