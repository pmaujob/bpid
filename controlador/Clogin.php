<?php

require_once '../modelo/MLogin.php';
require_once '../librerias/SessionVars.php';

class CLogin {

    private $correo;
    private $contrasena;
    private $ip;
    
    public function setCorreo($correo) {

        $this->correo = "'".$correo."'";
        
    }

    public function setContrasena($contrasena) {

        $this->contrasena = "'".sha1($contrasena)."'";
        
    }
    
    public function setIp($ip) {

        $this->ip = "'".$ip."'";
        
    }

    public function logIn() {

        return MLogin::logIn($this->correo, $this->contrasena, $this->ip);
        
    }
    
    public function setSession($usuario,$cedula){
        
        $sess = new SessionVars();
        $sess->setValue('usuario', $usuario);
        $sess->setValue('cedula', $cedula);
        $sess->setValue('correo', $this->correo);
        
    }

}

if ((isset($_POST['correo']) && isset($_POST['contrasena']) && isset($_POST['ip'])) && (!empty($_POST['correo']) && !empty($_POST['contrasena']) && !empty($_POST['ip']))) {

    $login = new CLogin();
    $login->setCorreo($_POST['correo']);
    $login->setContrasena($_POST['contrasena']);
    $login->setIp($_POST['ip']);
    $usuario = $login->logIn();
    if($usuario=="Ok")
        $login->setSession();
    
    echo $usuario;
    
}

?>