<?php

@session_start();

$raiz = $_SESSION['raiz'];

require_once $raiz . '/modelo/MActualizarUsuario.php';
require_once $raiz.'/librerias/CambiarFormatos.php';

class CActualizarUsuario {

    private $permisos = array();

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

    public function setPermisos($permisos) {
        $this->permisos = $permisos;
    }

    public function setEstado($cedula, $estado) {

        return MActualizarUsuario::setPermiso($cedula, ($estado == "true") ? 1 : 0);
    }

    public function actualizarPermisos($cedula) {
        
        return MActualizarUsuario::actualizarPermisos($cedula,$this->getPermisosJson());
        
    }

}

if (isset($_POST['op']) && !empty($_POST['op'])) {

    $act = new CActualizarUsuario();

    if ($_POST['op'] == 1) {
        if (isset($_POST['cedula']) && isset($_POST['estado']) && !empty($_POST['cedula']) && !empty($_POST['estado']))
            echo $act->setEstado($_POST['cedula'], $_POST['estado']);
        else
            echo "0";
    }else if ($_POST['op'] == 2) {

        if (isset($_POST['permisos']) && !empty($_POST['permisos']) && isset($_POST['cedula']) && !empty($_POST['cedula'])){

            $act->setPermisos($_POST['permisos']);
            echo $act->actualizarPermisos($_POST['cedula']);
            
        }else{
            echo "0";
        }
            
    }else {
        echo "0";
    }
    
}
?>

