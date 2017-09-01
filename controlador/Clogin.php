<?php

@session_start();

$raiz = $_SESSION['raiz'];

require_once '../modelo/MLogin.php';
require_once '../librerias/SessionVars.php';

class CLogin {

    private $correo;
    private $correoFilter;
    private $usuario;
    private $cedula;
    private $idLog;
    private $contrasena;
    private $ip;
    private $secretaria;
    
    public function setCorreo($correo) {
        
        $this->correo = $correo;
        $this->correoFilter = "'".$correo."'";
        
    }

    public function setContrasena($contrasena) {

        $this->contrasena = "'".sha1($contrasena)."'";
        
    }
    
    public function setIp($ip) {

        $this->ip = "'".$ip."'";
        
    }

    public function logIn() {
        
        $mLogin = new MLogin();
        $mLogin->logIn($this->correoFilter, $this->contrasena, $this->ip);
        $this->usuario = $mLogin->getUsuario();
        $this->cedula = $mLogin->getCedula();
        $this->idLog = $mLogin->getIdLog();
        $this->secretaria = $mLogin->getSecretaria();

        return $mLogin->getRespuesta();
        
    }
    
    public function setSession(){
        
        $sess = new SessionVars();
        $sess->init();
        $sess->setValue('usuario', $this->usuario);
        $sess->setValue('cedula', $this->cedula);
        $sess->setValue('correo', $this->correo);
        $sess->setValue('idLog', $this->idLog);
        $sess->setValue('idSec', $this->secretaria);
        
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