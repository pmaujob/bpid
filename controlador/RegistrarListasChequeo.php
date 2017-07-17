<?php

require_once '../librerias/CambiarFormatos.php';
require_once '../modelo/MRegistrarListasChequeo.php';

class RegistrarListasChequeo {

    private $idRad;
    private $requisitos;
    private $subRequisitos;

    public function getIdRad() {
        return $this->idRad;
    }

    public function getRequisitos() {
        return $this->requisitos;
    }

    public function getSubRequisitos() {
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

    public function registrar() {

        $reqArray = array();
        foreach ($this->getRequisitos() as $fila) {
            $aux = array("idReq" => $fila[0], "reqOp" => $fila[1], "reqObs" => $fila[2]);
            $reqArray[] = $aux;
        }

        $reqJson = CambiarFormatos::convertirAJsonItems($reqArray);
        $subJson = null;

        if ($this->getSubRequisitos() != null) {

            $subArray = array();
            foreach ($this->getSubRequisitos() as $fila) {
                $aux = array("idSub" => $fila[0], "subOp" => $fila[1], "subObs" => $fila[2]);
                $subArray[] = $aux;
            }

            $subJson = CambiarFormatos::convertirAJsonItems($subArray);
        }

        return MRegistrarListasChequeo::registrarListasChequeo($this->getIdRad(), $reqJson, $subJson);
    }

}

if (!empty($_POST['idRad'])) {

    $registrar = new RegistrarListasChequeo();
    $registrar->setIdRad($_POST['idRad']);
    $registrar->setRequisitos($_POST['reqData']);
    $registrar->setSubRequisitos($_POST['subData']);
    echo $registrar->registrar();
}
?>