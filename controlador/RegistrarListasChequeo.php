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
    private $numeroProyecto;

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

    public function setNumeroProyecto($numeroProyecto) {
        $this->numeroProyecto = $numeroProyecto;
    }

    public function getNumeroProyecto() {
        return $this->numeroProyecto;
    }

    public function registrar() {

        $reqArray = array();
        foreach ($this->getRequisitos() as $fila) {
            $temporal = str_replace("'", "''", $fila[2]);
            $aux = array("idReq" => $fila[0], "reqOp" => $fila[1], "reqObs" => $temporal);
            $reqArray[] = $aux;
        }

        $reqJson = CambiarFormatos::convertirAJsonItems($reqArray);
        $subJson = null;

        if ($this->getSubRequisitos() != null) {

            $subArray = array();
            foreach ($this->getSubRequisitos() as $fila) {
                $temporal = str_replace("'", "''", $fila[2]);
                $aux = array("idSub" => $fila[0], "subOp" => $fila[1], "subObs" => $fila[2]);
                $subArray[] = $aux;
            }

            $subJson = CambiarFormatos::convertirAJsonItems($subArray);
        }

        $resInsert = MRegistrarListasChequeo::registrarListasChequeo($this->getIdRad(), $reqJson, $subJson);
        if ($_POST['noCont'] != null) {
            if ($_POST['noCont'] > 0 && $resInsert == 1) {//enviar correo proyecto con items desaprobados
                $resCorreo = MRegistrarListasChequeo::getCorreoRad($this->getIdRad());
                $destino = "";
                foreach ($resCorreo as $obj) {
                    $destino = $obj[0];
                }
                $asunto = "Radicación Proyecto Bpid";
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
    $registrar->setnumeroProyecto($_POST['numeroProyecto']);


    echo $registrar->registrar();
} else {//enviar correo proyecto radicado
    $idRad = $_POST['idRad'];
    $res = MRegistrarListasChequeo::guardarEnviarListas($idRad);

    if ($res == 1) {

        $resCorreo = MRegistrarListasChequeo::getCorreoRad($idRad);
        $destino = "";
        foreach ($resCorreo as $obj) {
            $destino = $obj[0];
        }
        
        $asunto =utf8_decode("Radicación Proyecto Bpid") ;
        //$imagen="<img src='https://www.google.com.co/url?sa=i&rct=j&q=&esrc=s&source=images&cd=&cad=rja&uact=8&ved=0ahUKEwiskc_tqPHXAhXOSN8KHSz7BA8QjRwIBw&url=https%3A%2F%2Fimpuestovehicular.narino.gov.co%2Fportal-narino%2F&psig=AOvVaw028B8qrPFZxu-wEdnJhXVc&ust=1512509942289850'";
        $cuerpo = "Su proyecto numero ha sido radicado con éxito";
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