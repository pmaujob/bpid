<?php

@session_start();

$raiz = $_SESSION['raiz'];

require_once '../librerias/CambiarFormatos.php';
require_once '../modelo/MRegistrarDatosPrograma.php';

class RegistrarDatosPrograma {
    
    private $codRadicacion;
    private $progama;
    private $subprogramas;
    private $metas;
    
    function getCodRadicacion() {
        return $this->codRadicacion;
    }

    function getProgama() {
        return $this->progama;
    }

    function getSubprogramas() {
        return $this->subprogramas;
    }

    function getMetas() {
        return $this->metas;
    }

    function setCodRadicacion($codRadicacion) {
        $this->codRadicacion = $codRadicacion;
    }

    function setProgama($progama) {
        $this->progama = $progama;
    }

    function setSubprogramas($subprogramas) {
        $this->subprogramas = $subprogramas;
    }

    function setMetas($metas) {
        $this->metas = $metas;
    }

    
    public function registrar() {


    }

}

if (!isset($_POST['codRadicacion'])) {

    
    
}

?>
