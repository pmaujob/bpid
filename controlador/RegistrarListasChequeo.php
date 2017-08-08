<?php

@session_start();

$raiz = $_SESSION['raiz'];

require_once '../librerias/CambiarFormatos.php';
require_once '../modelo/MRegistrarListasChequeo.php';
require_once '../librerias/PHPMailer/PHPMailerAutoload.php';

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

        if (isset($_POST['noCont']) && $_POST['noCont'] > 0 && $resInsert == 1) {//enviar correo proyecto con items desaprobados
            enviarDummy();
            /*
              $correo = new phpmailer();

              $correo->PluginDir = "../librerias/PHPMailer/";
              $correo->Mailer = "smtp";
              $correo->Host = "smtp.gmail.com";
              $correo->SMTPAuth = false;
              $correo->Username = "planeacionbpid@gmail.com";
              $correo->Password = "bpid2017";

              $correo->From = "planeacionbpid@gmail.com";
              $correo->FromName = "Planeación BPID";
              $correo->Timeout = 0;

              $correo->AddAddress("danielernestodaza@hotmail.com");
              $correo->Subject = "Información de Radicación Proyecto - Bpid";
              $correo->Body = "<b>Mensaje de prueba mandado con phpmailer en formato html</b>";
              $correo->AltBody = "Mensaje de prueba mandado con phpmailer en formato solo texto";

              //$correoEnviado = $correo->send();
              //return var_dump($correo->send());

              $intentos = 1;
              while ((!$correoEnviado) && ($intentos < 3)) {
              sleep(5);
              $correoEnviado = $correo->send();
              $intentos++;
              } */
        }

        //return $resInsert;
    }

}

if (!empty($_POST['idRad']) && !isset($_POST['guardarEnviar'])) {

    $registrar = new RegistrarListasChequeo();
    $registrar->setIdRad($_POST['idRad']);
    $registrar->setRequisitos($_POST['reqData']);
    $registrar->setSubRequisitos($_POST['subData']);

    echo $registrar->registrar();
} else if (!empty($_POST['idRad']) && !isset($_POST['guardarEnviar'])) {//enviar correo proyecto radicado
    $res = MRegistrarListasChequeo::guardarEnviarListas($_POST['idRad']);

    if ($res == 1) {

        $correo = new phpmailer();

        $mail->PluginDir = "../librerias/PHPMailer/";
        $mail->Mailer = "smtp";
        $mail->Host = "smtp.gmail.com";
        $mail->SMTPAuth = true;
        $mail->Username = "planeacionbpid@gmail.com";
        $mail->Password = "bpid2017";

        $mail->From = "planeacionbpid@gmail.com";
        $mail->FromName = "Planeación BPID";
        $mail->Timeout = 0;

        $mail->AddAddress("danielernestodaza@hotmail.com");
        $mail->Subject = "Información de Radicación Proyecto - Bpid";
        $mail->Body = "<b>Mensaje de prueba mandado con phpmailer en formato html</b>";
        $mail->AltBody = "Mensaje de prueba mandado con phpmailer en formato solo texto";

        $correoEnviado = $mail->Send();

        $intentos = 1;
        while ((!$exito) && ($intentos < 3)) {
            sleep(5);
            $exito = $mail->Send();
            $intentos = $intentos + 1;
        }
    }

    echo $res;
}

function enviarDummy() {
    // El mensaje
    $mensaje = "Línea 1\r\nLínea 2\r\nLínea 3";

// Si cualquier línea es más larga de 70 caracteres, se debería usar wordwrap()
    $mensaje = wordwrap($mensaje, 70, "\r\n");

// Enviar
    echo var_dump(mail('danielernestodaza@hotmail.com', 'Prueba maldición', $mensaje));
}

?>