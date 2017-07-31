<?php

@session_start();

$raiz = $_SESSION['raiz'];

require_once $raiz.'modelo/MCrearUsuario.php';

class CCrearUsuario {

    private $cedula;
    private $nombre;
    private $apellido;
    private $correo;
    private $dependencia;

    public function setCedula($cedula) {
        $this->cedula = $cedula;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setApellido($apellido) {
        $this->apellido = $apellido;
    }

    public function setCorreo($correo) {
        $this->correo = $correo;
    }

    public function setDependencia($dependencia) {
        $this->dependencia = $dependencia;
    }

    private function getCedula() {
        return $this->cedula;
    }

    private function getNombre() {
        return $this->nombre;
    }

    private function getApellido() {
        return $this->apellido;
    }

    private function getCorreo() {
        return $this->correo;
    }

    private function getDependencia() {
        return $this->dependencia;
    }

    public function registrarUsuario() {
        
        return MCrearUsuario::crearUsuario($this->getCedula(), $this->getNombre(), $this->getApellido(), $this->getCorreo(), $this->getDependencia());
        
    }

}

?>