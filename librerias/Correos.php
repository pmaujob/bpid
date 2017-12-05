<?php
@session_start();

$raiz = $_SESSION['raiz'];
require_once $raiz . '/librerias/PHPMailer/PHPMailerAutoload.php';

class Correos {

    private $phpMailer;

    public function inicializar() {
        
        $this->phpMailer = new PHPMailer();

        $this->phpMailer->IsSMTP();
        $this->phpMailer->SMTPAuth = true;
        $this->phpMailer->Host = "smtp.gmail.com";
        $this->phpMailer->Username = "planeacionbpid@gmail.com";
        $this->phpMailer->Password = "bpid2017";
        $this->phpMailer->Port = 587;
        $this->phpMailer->From = "planeacionbpid@gmail.com"; 
        $this->phpMailer->FromName = "BPID"; 
        $this->phpMailer->IsHTML(true); 

    }
    
    public function getMierda(){
        return $this->phpMailer->From;
    }

    public function setDestinatario($correoDestinatario) {
        $this->phpMailer->addAddress($correoDestinatario);
    }

    public function armarCorreo($asunto, $cuerpo, $altCuerpo) {
        $this->phpMailer->Subject = $asunto;
        $this->phpMailer->Body = $cuerpo;
        $this->phpMailer->AltBody = $altCuerpo;
    }

    public function enviar() {
        return $this->phpMailer->Send();
    }

}
?>

