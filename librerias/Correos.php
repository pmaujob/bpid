<?php

@session_start();

$raiz = $_SESSION['raiz'];
require_once $raiz . '/librerias/PHPMailer/PHPMailerAutoload.php';
require_once $raiz . '/librerias/CambiarFormatos.php';

class Correos {

    private $phpMailer;
    public $raiz;

    public function inicializar() {

        $this->phpMailer = new PHPMailer;

        $this->phpMailer->IsSMTP();
        $this->SMTPDebug = 2;
        $this->Debugoutput = 'html';
        $this->SMTPSecure = 'tls';
        $this->phpMailer->SMTPAuth = true;
        $this->phpMailer->Port = 587;
        $this->phpMailer->Host = "smtp.gmail.com";
        $this->phpMailer->Username = "planeacionbpid@gmail.com";
        $this->phpMailer->Password = "bpid2017";
        $this->phpMailer->setFrom('planeacionbpid@gmail.com', 'BPID');
    }

    public function setDestinatario($correoDestinatario) {
        $this->phpMailer->addAddress($correoDestinatario);
    }

    public function armarCorreo($asunto, $msg, $altCuerpo) {
        $this->phpMailer->Subject = $asunto;

        $body = str_replace('HORA_SISTEMA', CambiarFormatos::cambiarFecha(date("m/d/Y")), file_get_contents($this->raiz . '/vistas/correos/correoRadicacion.php'));
        $body = str_replace('MSG_REPLACE', $msg, $body);

        $this->phpMailer->msgHTML($body);
        $this->phpMailer->AltBody = $altCuerpo;
    }

    public function enviar() {
        return $this->phpMailer->Send();
    }

}
?>

