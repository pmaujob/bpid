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
    private $correoResponsable;
    private $usuario;
    private $correoUsuario;
    public $raiz;

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

    private function getCorreoResponsable() {
        return $this->correoResponsable;
    }

    private function getCorreoUsuario() {
        return $this->correoUsuario;
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

    public function setResponsable($responsable) {
        $this->responsable = $responsable;
    }

    private function setCorreoResponsable($setCorreoResponsable) {
        $this->setCorreoResponsable = $setCorreoResponsable;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }

    public function setCorreoUsuario($correoUsuario) {
        $this->correoUsuario = $correoUsuario;
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
        $this->setCorreoUsuario($sess->getValue('correo'));

        $responsable = MFinalizarViabilidad::getDatosUsuario($this->getIdRadicacion());
        $this->setResponsable($responsable->fetch(PDO::FETCH_OBJ)->nom);
        $this->setCorreoResponsable($responsable->fetch(PDO::FETCH_OBJ)->correo);

        $datosProyecto = CargarViabilizados::getViabilizados($this->getCodBpid(), 1)->fetch(PDO::FETCH_OBJ);

        $asunto = utf8_decode("Estado Proyecto - Bpid");

        ob_start();
        ?>
        <span><strong>Estimado <?php echo $this->getResponsable(); ?></strong></span> 
        <br>
        <p style="text-align: justify;">Informamos que el proyecto <strong><?php echo $datosProyecto->nompro . " "; ?></strong> 
            con número BPID <strong><?php echo $datosProyecto->num ?></strong> tiene 
            Viabilidad <strong><?php echo ($this->getEstado() === "A" ? "DESFAVORABLE" : "FAVORABLE"); ?></strong>.          
        </p>
        <br>
        <p>Para más información por favor comunicarse con la entidad.</p>
        <?php
        $msg = ob_get_clean();

        $altCuerpo = nl2br("Estimado " . $this->getResponsable() . "."
                . "\n\nInformamos que su proyecto $datosProyecto->nompro con número BPID $datosProyecto->num "
                . "tiene Viabilidad" . ($this->getEstado() === "A" ? "FAVORABLE." : "DESFAVORABLE.")
                . "\n\nPara más información por favor comunicarse con la entidad."
                . "\n\n* Este es un email que se ha generado automáticamente, por favor no lo responda *"
                . "\n\nSí no tiene conocimiento sobre el tema, por favor ignore este mensaje.");


        $this->enviarCorreo($this->getCorreoResponsable(), $asunto, $msg, $altCuerpo, $this->raiz, ($this->getEstado() !== "A" ? $this->getCorreoUsuario() : ""));


        if ($this->getEstado() !== "A") {//no viable
            $correos = MFinalizarViabilidad::getCorreosRegistro();

            ob_start();
            ?>
            <p style="text-align: justify;">Informamos que el proyecto <strong><?php echo $datosProyecto->nompro . " "; ?></strong> 
                con número BPID <strong><?php echo $datosProyecto->num ?></strong> se encuetra disponible 
                para el control posterior de la viabilidad.          
            </p>
            <br>
            <?php
            $msg = ob_get_clean();

            $altCuerpo = nl2br("Informamos que su proyecto $datosProyecto->nompro con número BPID $datosProyecto->num "
                    . "se encuetra disponible para el control posterior de la viabilidad."
                    . "\n\n* Este es un email que se ha generado automáticamente, por favor no lo responda *"
                    . "\n\nSí no tiene conocimiento sobre el tema, por favor ignore este mensaje.");
            foreach ($correos as $row) {

                $this->enviarCorreo($row[0], $asunto, $msg, $altCuerpo, $this->raiz);
            }
        }
    }

    private function enviarCorreo($destino, $asunto, $cuerpo, $altCuerpo, $raiz, $copia = "") {

        $correo = new Correos();
        $correo->raiz = $raiz;
        $correo->inicializar();
        $correo->setDestinatario($destino);
        if ($copia != "") {
            $correo->addCopia($copia);
        }
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
    $cFinalizarViabilidad->raiz = $raiz;
    $cFinalizarViabilidad->setIdRadicacion($_POST['idRad']);
    $cFinalizarViabilidad->setResponsables($_POST['responsables']);
    $cFinalizarViabilidad->setEstado("'" . $_POST['est'] . "'");
    $cFinalizarViabilidad->setCodBpid($_POST['codBpid']);
    echo $cFinalizarViabilidad->registrarResponsables();
} else {

    echo "vacio";
}
?>

