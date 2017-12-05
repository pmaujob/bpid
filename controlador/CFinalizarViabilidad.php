<?php

@session_start();

$raiz = $_SESSION['raiz'];

require_once $raiz . '/modelo/MFinalizarViabilidad.php';
require_once $raiz . '/librerias/CambiarFormatos.php';
require_once $raiz . '/librerias/Correos.php';
require_once $raiz . '/librerias/SessionVars.php';
require_once $raiz . '/modelo/CargarViabilizados.php';

class CFinalizarViabilidad {

    private $idRadicacion;
    private $codBpid;
    private $responsables = array(array());
    private $estado;
    private $responsable;
    private $usuario;

    private function getIdRadicacion() {
        return $this->idRadicacion;
    }

    private function getResponsables() {
        return $this->responsables;
    }

    private function getEstado() {
        return $this->estado;
    }

    private function getResponsable() {
        return $this->responsable;
    }

    private function getUsuario() {
        return $this->usuario;
    }

    private function getCodBpid() {
        return $this->codBpid;
    }

    public function setIdRadicacion($idRadicacion) {
        $this->idRadicacion = $idRadicacion;
    }

    public function setResponsables($responsables) {
        $this->responsables = $responsables;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }

    public function setResponsable($responsable) {
        $this->responsable = $responsable;
    }

    public function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

    public function setCodBpid($codBpid) {
        $this->codBpid = $codBpid;
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
        $this->enviar();
        return MFinalizarViabilidad::registrarViabilidad($this->getIdRadicacion(), $this->getResponsablesJson(), $this->getEstado());
    }

    public function enviar() {

        $sess = new SessionVars();
        $this->setUsuario($sess->getValue('correo'));
        $this->setResponsable(MFinalizarViabilidad::getDatosUsuario($this->getIdRadicacion())->fetch(PDO::FETCH_OBJ)->correo);

        $asunto = "Estado Proyecto - Bpid";

        if ($this->getEstado() === "A") {//no viable
                    
            $cuerpo = "El proyecto " . $datosProyecto->nompro . " con numero BPID: " . $datosProyecto->num . "Su proyecto tiene viabilidad desfavorable";
            $altCuerpo = "El proyecto " . $datosProyecto->nompro . " con numero BPID: " . $datosProyecto->num . "Su proyecto tiene viabilidad no favorable.";

            $destino = $this->getResponsable();

            $this->enviarCorreo($destino, $asunto, $cuerpo, $altCuerpo);
        } else {
            $cuerpo = "El proyecto:" . $datosProyecto->nompro . " con numero BPID: " . $datosProyecto->num . "Su proyecto tiene viabilidad favorable";
            $altCuerpo = "El proyecto " . $datosProyecto->nompro . " con numero BPID: " . $datosProyecto->num . "Su proyecto tiene viabilidad favorable";


            $destino = $this->getResponsable();
            $this->enviarCorreo($destino, $asunto, $cuerpo, $altCuerpo);

            $destino = $this->getUsuario();
            $this->enviarCorreo($destino, $asunto, $cuerpo, $altCuerpo);

            $correos = MFinalizarViabilidad::getCorreosRegistro();
            $datosProyecto = CargarViabilizados::getViabilizados($this->getCodBpid(), 1)->fetch(PDO::FETCH_OBJ);

            $cuerpo = "El proyecto " . $datosProyecto->nompro . " con numero BPID: " . $datosProyecto->num . " se encuetra disponible para el control psterior de la viabilidad.";
            $altCuerpo = "El proyecto " . $datosProyecto->nompro . " con numero BPID: " . $datosProyecto->num . " se encuetra disponible para el control psterior de la viabilidad.";

            foreach ($correos as $row) {
                $this->enviarCorreo($row[0], $asunto, $cuerpo, $altCuerpo);
            }
        }
    }

    private function enviarCorreo($destino, $asunto, $cuerpo, $altCuerpo) {

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
    $cFinalizarViabilidad->setEstado("'" . $_POST['est'] . "'");
    $cFinalizarViabilidad->setCodBpid($_POST['codBpid']);
    echo $cFinalizarViabilidad->registrarResponsables();
} else {

    echo "vacio";
}
?>

