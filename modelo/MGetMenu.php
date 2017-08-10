<?php

@session_start();

$raiz = $_SESSION['raiz'];

require_once $raiz.'/librerias/ConexionPDO.php';
require_once $raiz.'/librerias/SessionVars.php';

class MGetMenu{
    
    public static function getMenu($op){
        
        $sess = new SessionVars();
        $usuario = "'".$sess->getValue('cedula')."'";
        
        $sql = "";
        
        if($op == 1)
            $sql = 'select id, mod, fun from seguridad.get_menu('.$usuario.','.$op.') as ("id" integer, "mod" varchar, "fun" varchar);';
        else if($op == 2)
            $sql = 'select id, mod from seguridad.get_menu('.$usuario.','.$op.') as ("id" integer, "mod" varchar);';
        
        $con = new ConexionPDO();
        $con->conectar("PG");
        $res = $con->consultar($sql);
        $con->cerrarConexion();
        
        return $res;
        
    }
    
}

?>
