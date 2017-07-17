<?php

require_once '../librerias/CambiarFormatos.php';

class RegistrarListasChequeo {

    private $idRad;
    private $requisitos;
    private $subRequisitos;

    public function getIdRad(){
        return $this->idRad;
    }
    
    public function getRequisitos(){
        return $this->requisitos;
    }
    
    public function getSubRequisitos(){
        return $this->subRequisitos;
    }
    
    public function setIdRad($idRad) {
        $this->idRad = $idRad;
    }

    public function setRequisitos($requisitos) {
        $this->requisitos = $requisitos;
    }

    public function setSubRequisitos($subRequisitos) {
        $this->subRequisitos = $subRequisitos;
    }

}

if (!empty($_POST['idRad'])) {

    $registrar = new RegistrarListasChequeo();
    $registrar->setIdRad($_POST['idRad']);
    $registrar->setRequisitos($_POST['reqData']);
    if ($_POST['subData'] == null) {
        $registrar->setSubRequisitos($_POST['subData']);
    }
    
    $reqArray = array();
    $subArray = array();
    
    foreach ($registrar->getRequisitos() as $fila) {
        $aux = array("idReq" => $fila[0], "op" => $fila[1], "obs" => $fila[2]);
        $arrayDef[] = $aux;
    }
    $reqJson = CambiarFormatos::convertirAJsonItems($arrayDef);
    
}
?>