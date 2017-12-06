<?php

@session_start();

$raiz = $_SESSION['raiz'];
require_once $raiz . '/librerias/PHPMailer/PHPMailerAutoload.php';

class Correos {

    private $phpMailer;

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

    public function armarCorreo($asunto, $cuerpo, $altCuerpo) {
        $this->phpMailer->Subject = $asunto;
        ob_start();
        include '../../vistas/correos/correoRadicacion.php';
        $this->phpMailer->Body = ob_get_clean();
        $this->phpMailer->AltBody = $altCuerpo;
    }

    public function enviar() {
        return $this->phpMailer->Send();
    }

}
?>

