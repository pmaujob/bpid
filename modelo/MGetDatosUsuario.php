<?php

require_once '../librerias/ConexionPDO.php';

class MGetDatosUsuario{
    
    private $nombres;
    private $apellidos;
    private $correo;
    private $dependencia;
    
    private function setNombres($nombres) {
        $this->nombres = $nombres;
    }

    private function setApellidos($apellidos) {
        $this->apellidos = $apellidos;
    }

    private function setCorreo($correo) {
        $this->correo = $correo;
    }

    private function setDependencia($dependencia) {
        $this->dependencia = $dependencia;
    }
    
    function getNombres() {
        return $this->nombres;
    }

    function getApellidos() {
        return $this->apellidos;
    }

    function getCorreo() {
        return $this->correo;
    }

    function getDependencia() {
        return $this->dependencia;
    }
    
    public function existeUsuarioEnGovernacion($cedula){
        
        $sql = "select (case when count(identificacion)>0 then 'Ok' else 'No' end) as cedula from servidorespublicosycontratistas where identificacion='".$cedula."';";
        
        $con = new ConexionPDO();
        $con->conectar("MS");
        $res = $con->consultar($sql);
        $usuario = false;
        
        while($resultado = $res->fetch(PDO::FETCH_OBJ))
            $usuario = ($resultado->cedula)==="Ok" ? true : false;
        
        $con->cerrarConexion();
           
        return $usuario;
        
    }
    
    public function existeUsuarioEnBpid($cedula){
        
        $cedula = "'".$cedula."'";
        
        $sql = 'select cedula from existe_usuario('.$cedula.') as ("cedula" varchar);';
        
        $con = new ConexionPDO();
        $con->conectar("PG");
        $res = $con->consultar($sql);
        $usuario = false;
        
        while($resultado = $res->fetch(PDO::FETCH_OBJ))
            $usuario = ($resultado->cedula)==="Ok" ? true : false;
        
        $con->cerrarConexion();
        
        return $usuario;
        
    }


    public function setDatosUsuario($cedula){
        
        $sql = "select nombres as nom, concat(apellido,' ',segundoApellido) as ape, correo as correo, dependencia as dep from servidorespublicosycontratistas where identificacion='".$cedula."';";
        
        $con = new ConexionPDO();
        $con->conectar("MS");
        $res = $con->consultar($sql);
        
        while($resultado = $res->fetch(PDO::FETCH_OBJ)){
            $this->setNombres($resultado->nom);
            $this->setApellidos($resultado->ape);
            $this->setCorreo($resultado->correo);
            $this->setDependencia($resultado->dep);
        }
        
    }
    
}

?>