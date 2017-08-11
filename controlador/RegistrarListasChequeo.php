<?php

@session_start();

$raiz = $_SESSION['raiz'];

require_once '../librerias/CambiarFormatos.php';
require_once '../modelo/MRegistrarListasChequeo.php';
require_once '../librerias/Correos.php';

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

        $resInsert = MRegistrarListasChequeo::registrarListasChequeo($this->getIdRad(), $reqJson, $subJson);

        if ($_POST['noCont'] != null) {
            if ($_POST['noCont'] > 0 && $resInsert == 1) {//enviar correo proyecto con items desaprobados
                $destino = MRegistrarListasChequeo::getCorreoRad($this->getIdRad());
                $asunto = "Radicación Proyecto - Bpid";
                $cuerpo = "Su proyecto no fue radicado con éxito debido a que no se aprobaron " + $_POST['noCont'] + ", items.";
                $altCuerpo = "Su proyecto no fue radicado con éxito debido a que no se aprobaron " + $_POST['noCont'] + ", items.";

                enviarCorreo($destino, $asunto, $cuerpo, $altCuerpo);
            }
        }
        return $resInsert;
    }

}

if (!isset($_POST['guardarEnviar'])) {

    $registrar = new RegistrarListasChequeo();
    $registrar->setIdRad($_POST['idRad']);
    $registrar->setRequisitos($_POST['reqData']);
    $registrar->setSubRequisitos($_POST['subData']);

    echo $registrar->registrar();
} else {//enviar correo proyecto radicado
    $idRad = $_POST['idRad'];
    $res = MRegistrarListasChequeo::guardarEnviarListas($idRad);

    if ($res == 1) {

        $destino = MRegistrarListasChequeo::getCorreoRad($idRad);
        $asunto = "Radicación Proyecto - Bpid";
        $cuerpo = "Su proyecto ha sido radicado con éxito";
        $altCuerpo = "Su proyecto ha sido radicado con éxito";

        enviarCorreo($destino, $asunto, $cuerpo, $altCuerpo);
    }

    echo $res;
}

function enviarCorreo($destino, $asunto, $cuerpo, $altCuerpo) {

    $correo = new Correos();

    $correo->inicializar();
    $correo->setDestinatario($destino);
    $correo->armarCorreo($asunto, $cuerpo, $altCuerpo);

    $correoEnviado = $correo->enviar();

    $intentos = 1;
    while ((!$correoEnviado) && ($intentos < 3)) {
        sleep(5);
        $correoEnviado = $correo->enviar();
        $intentos++;
    }

    return $correoEnviado;
}

?>