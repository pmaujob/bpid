<?php

@session_start();

$raiz = $_SESSION['raiz'];

require_once '../librerias/CambiarFormatos.php';
require_once '../modelo/MRegistrarMetas.php';

class RegistrarMetas {

    private $codRadicacion;
    private $metas;

    function getCodRadicacion() {
        return $this->codRadicacion;
    }

    function getMetas() {
        return $this->metas;
    }

    function setCodRadicacion($codRadicacion) {
        $this->codRadicacion = $codRadicacion;
    }

    function setMetas($metas) {
        $this->metas = $metas;
    }

    public function registrar() {

        $newArray = array();
        foreach ($this->getMetas() as $meta) {
            $newRow = array("idMeta" => $meta);

            $newArray[] = $newRow;
        }

        return MRegistrarMetas::registrarMetas($this->getCodRadicacion(), CambiarFormatos::convertirAJsonItems($newArray));
;
    }

}

$datosPrograma = new RegistrarMetas();
$datosPrograma->setCodRadicacion($_POST['idRad']);
$datosPrograma->setMetas(array());
$datosPrograma->setMetas($_POST['metas']);

echo $datosPrograma->registrar();

?>
