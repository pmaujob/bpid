<?php

@session_start();

$raiz = $_SESSION['raiz'];

require_once $raiz . '/modelo/MFinalizarViabilidad.php';
require_once $raiz . '/librerias/CambiarFormatos.php';
require_once $raiz . '/librerias/Correos.php';

class CFinalizarViabilidad {

    private $idRadicacion;
    private $responsables = array(array());

    private function getIdRadicacion() {
        return $this->idRadicacion;
    }

    private function getResponsables() {
        return $this->responsables;
    }

    public function setIdRadicacion($idRadicacion) {
        $this->idRadicacion = $idRadicacion;
    }

    public function setResponsables($responsables) {
        $this->responsables = $responsables;
    }

    public function getResponsablesJson() {
        $responsables = array();
        foreach ($this->getResponsables() as $fila) {
            $aux = array("Cedula" => $fila[0], "Nombres" => $fila[1], "Apellidos" => $fila[2], "Cargo" => $fila[3]);
            $responsables[] = $aux;
        }

        $responsablesJson = CambiarFormatos::convertirAJsonItems($responsables);

        return $responsablesJson;
    }

    public function registrarResponsables() {
        return MFinalizarViabilidad::registrarViabilidad($this->getIdRadicacion(), $this->getResponsablesJson());
    }

    public function enviarCorreo() {

        $destino = "pmaujob@gmail.com";
        $asunto = "Radicación Proyecto - Bpid";
        $cuerpo = "Su proyecto no fue radicado con éxito debido a que no se aprobaron items.";
        $altCuerpo = "Su proyecto no fue radicado con éxito debido a que no se aprobaron items.";

        $this->enviar($destino, $asunto, $cuerpo, $altCuerpo);
    }

    private function enviar($destino, $asunto, $cuerpo, $altCuerpo) {

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

}

if ((isset($_POST['idRad']) && isset($_POST['responsables'])) && (!empty($_POST['idRad']) && !empty($_POST['responsables']))) {

    $cFinalizarViabilidad = new CFinalizarViabilidad();
    $cFinalizarViabilidad->setIdRadicacion($_POST['idRad']);
    $cFinalizarViabilidad->setResponsables($_POST['responsables']);
    $cFinalizarViabilidad->enviarCorreo();
    echo $cFinalizarViabilidad->registrarResponsables();
} else {

    echo "vacio";
}
?>

