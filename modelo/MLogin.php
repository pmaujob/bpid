<?php

require_once '../librerias/ConexionPDO.php';

class MLogin {
    
    private $con;
    private $correo;
    private $usuario;
    private $cedula;
    private $idLog;
    private $respuesta;
    private $secretaria;

    public function logIn($correo, $contrasena, $ip) {
        
        $this->con = new ConexionPDO();
        $this->con->conectar("PG");
        
        $this->correo = $correo;

        $sql = 'select cont from login(' . $correo . ',' . $contrasena . ') as ("cont" varchar);';

        $res = $this->con->consultar($sql);

        $respuesta = "No";

        while ($resultado = $res->fetch(PDO::FETCH_OBJ)){
            $respuesta = $resultado->cont;
        }

        if ($respuesta == "Ok") {

            $sql = 'select id from seguridad.ing_logs_login(' . $ip . ',' . $correo . ') as ("id" integer);';

            $res = $this->con->consultar($sql);
            
            while ($resultado = $res->fetch(PDO::FETCH_OBJ)){
                $this->idLog = $resultado->id;
            }
            
            $this->setDatosUsuario();
            
        }

        $this->con->cerrarConexion();

        $this->respuesta = $respuesta;
        
    }
    
    private function setDatosUsuario(){
        
        $sql = 'select usuario, ced, sec from seguridad.get_datos_usuario('.$this->correo.') as ("usuario" varchar, "ced" varchar, "sec" integer);';
        
        $res = $this->con->consultar($sql);
        
        while ($resultado = $res->fetch(PDO::FETCH_OBJ)){
            $this->usuario = $resultado->usuario;
            $this->cedula = $resultado->ced;
            $this->secretaria = $resultado->sec;
        }
        
    }
    
    public function getUsuario(){
        
        return $this->usuario;
        
    }
    
    public function getCedula(){
        
        return $this->cedula;
        
    }
    
    public function getIdLog(){
        
        return $this->idLog;
        
    }
    
    public function getRespuesta(){
        
        return $this->respuesta;
        
    }
    
    public function getSecretaria(){
        
        return $this->secretaria;
        
    }

}

?>