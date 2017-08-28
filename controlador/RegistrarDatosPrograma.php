<?php

@session_start();

$raiz = $_SESSION['raiz'];

require_once '../librerias/CambiarFormatos.php';
require_once '../modelo/MRegistrarDatosPrograma.php';

class RegistrarDatosPrograma {

    private $codRadicacion;
    private $programa;
    private $subprogramas;
    private $metas;

    function getCodRadicacion() {
        return $this->codRadicacion;
    }

    function getPrograma() {
        return $this->programa;
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

    function setPrograma($programa) {
        $this->programa = $programa;
    }

    function setSubprogramas($subprogramas) {
        $this->subprogramas = $subprogramas;
    }

    function setMetas($metas) {
        $this->metas = $metas;
    }

    public function registrar() {

        $resInsPrograma = MRegistrarDatosPrograma::registrarDatosPrograma($this->getCodRadicacion(), $this->getPrograma());
        $resInsSubprogramas = MRegistrarDatosPrograma::registrarDatosSubprograma($this->getCodRadicacion(), $this->getSubprogramas());
        $resInsMetas = MRegistrarDatosPrograma::registrarDatosMetas($this->getCodRadicacion(), $this->getMetas());
     
        return $resInsPrograma . "|" . $resInsSubprogramas . "|" . $resInsMetas; 
        
    }

}

if (isset($_POST['codRadicacion'])) {

    $datosPrograma = new RegistrarDatosPrograma();

    $datosPrograma->setCodRadicacion($_POST['codRadicacion']);
    $datosPrograma->setPrograma($_POST['codPrograma']);
    $datosPrograma->setSubprogramas($_POST['subprogramas']);
    $datosPrograma->setMetas($_POST['metas']);

    echo $datosPrograma->registrar();
}
?>
