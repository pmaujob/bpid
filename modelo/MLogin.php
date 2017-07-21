<?php

require_once '../librerias/ConexionPDO.php';

class MLogin {

    public static function logIn($correo, $contrasena, $ip) {

        $sql = 'select cont from login(' . $correo . ',' . $contrasena . ') as ("cont" varchar);';

        $con = new ConexionPDO();
        $con->conectar("PG");
        $res = $con->consultar($sql);

        $respuesta = "No";
        $usuario = "";
        $cedula = "";

        while ($resultado = $res->fetch(PDO::FETCH_OBJ)){
            $respuesta = $resultado->cont;
        }

        if ($respuesta == "Ok") {

            $sql = 'select from ing_logs_login(' . $ip . ',' . $correo . ');';

            $res = $con->consultar($sql);
            
        }

        $con->cerrarConexion();

        return $respuesta;
        
    }
    
    public function setDatosUsuario(){
        
        $con = new ConexionPDO();
        $con->conectar("PG");
        $res = $con->consultar($sql);
        
    }

}

?>