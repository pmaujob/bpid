<?php

@session_start();

$raiz = $_SESSION['raiz'];

require_once $raiz . '/modelo/MCrearUsuario.php';
require_once $raiz . '/librerias/CambiarFormatos.php';

class CCrearUsuario {

    private $cedula;
    private $nombre;
    private $apellido;
    private $correo;
    private $dependencia;
    private $clave;
    private $permisos = array();

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

    public function setClave($clave) {
        $this->clave = sha1($clave);
    }

    public function setPermisos($permisos) {
        $this->permisos = $permisos;
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

    private function getClave() {
        return $this->clave;
    }

    private function getPermisos() {
        return $this->permisos;
    }

    private function getPermisosJson() {
        $permisosArray = array();
        foreach ($this->getPermisos() as $fila) {
            $aux = array("idFun" => $fila);
            $permisosArray[] = $aux;
        }

        $permisosJson = CambiarFormatos::convertirAJsonItems($permisosArray);
        
        return $permisosJson;
        
    }

    public function registrarUsuario() {

        return MCrearUsuario::crearUsuario($this->getCedula(), $this->getNombre(), $this->getApellido(), $this->getCorreo(), $this->getDependencia(), $this->getClave(), $this->getPermisosJson());
    
    }

}

if ((isset($_POST['cedula']) && isset($_POST['nombre']) && isset($_POST['apellido']) && isset($_POST['correo']) && isset($_POST['dependencia']) && isset($_POST['permisos'])) && (!empty($_POST['cedula']) && !empty($_POST['nombre']) && !empty($_POST['apellido']) && !empty($_POST['correo']) && !empty($_POST['dependencia']) && !empty($_POST['permisos']))) {

    $usuario = new CCrearUsuario();
    $usuario->setCedula($_POST['cedula']);
    $usuario->setNombre($_POST['nombre']);
    $usuario->setApellido($_POST['apellido']);
    $usuario->setCorreo($_POST['correo']);
    $usuario->setDependencia($_POST['dependencia']);
    $usuario->setClave($_POST['cedula']);
    $usuario->setPermisos($_POST['permisos']);

    echo $usuario->registrarUsuario();
}
?>