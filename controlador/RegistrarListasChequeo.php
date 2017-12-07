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
    public $raiz;

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
                $datosCorreo = array();
                foreach ($resCorreo as $obj) {

                    for ($i = 0; $i < count($obj); $i++) {
                        $datosCorreo[] = $obj[$i];
                    }
                }
                $asunto = utf8_decode("Radicación Proyecto Bpid");
                ob_start();
                ?>
                <span><strong>Estimado <?php echo $datosCorreo[1]; ?></strong></span> 
                <br>
                <p style="text-align: justify;">Informamos que su proyecto <strong><?php echo $datosCorreo[2] . " "; ?></strong> 
                    con número de radicación <strong><?php echo $datosCorreo[3]; ?></strong> NO cumplió con 
                    algunos requisitos de las listas de chequeo, y por lo tanto, <strong>NO</strong> fue radicado.          
                </p>
                <br>
                <p>Para más información por favor comunicarse con la entidad.</p>
                <?php
                $msg = ob_get_clean();
                $altCuerpo = nl2br("Estimado $datosCorreo[1]."
                        . "\n\nInformamos que su proyecto $datosCorreo[2] con número de radicación $datosCorreo[3] "
                        . "NO cumplió con algunos requisitos de las listas de chequeo, y por lo tanto, NO fue radicado."
                        . "\n\nPara más información por favor comunicarse con la entidad."
                        . "\n\n* Este es un email que se ha generado automáticamente, por favor no lo responda *"
                        . "\n\nSí no tiene conocimiento sobre el tema, por favor ignore este mensaje.");

                enviarCorreo($datosCorreo[0], $asunto, $msg, $altCuerpo, $this->raiz);
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
    $registrar->raiz = $raiz;

    echo $registrar->registrar();
} else {//enviar correo proyecto radicado
    $idRad = $_POST['idRad'];
    $res = MRegistrarListasChequeo::guardarEnviarListas($idRad);
    if ($res == 1) {

        $resCorreo = MRegistrarListasChequeo::getCorreoRad($idRad);
        $datosCorreo = array();
        foreach ($resCorreo as $obj) {

            for ($i = 0; $i < count($obj); $i++) {
                $datosCorreo[] = $obj[$i];
            }
        }

        $asunto = utf8_encode("Radicación Proyecto Bpid");
        ob_start();
        ?>
        <span><strong>Estimado <?php echo $datosCorreo[1]; ?></strong></span> 
        <br>
        <p style="text-align: justify;">Informamos que su proyecto <strong><?php echo $datosCorreo[2] . " "; ?></strong> 
            con número de radicación <strong><?php echo $datosCorreo[3]; ?></strong> cumplió con 
            los requisitos de las listas de chequeo, y por ende, fue <strong>radicado con éxito.</strong>          
        </p>   
        <?php
        $msg = ob_get_clean();
        $altCuerpo = nl2br("Estimado $datosCorreo[1]."
                . "\n\nInformamos que su proyecto $datosCorreo[2]"
                . "con número de radicación $datosCorreo[3] cumplió "
                . "con los requisitos de las listas de chequeo, y por ende, fue radicado con éxito. "
                . "\n\n* Este es un email que se ha generado automáticamente, por favor no lo responda *"
                . "\n\nSí no tiene conocimiento sobre el tema, por favor ignore este mensaje.");

        enviarCorreo($datosCorreo[0], $asunto, $msg, $altCuerpo, $raiz);
    }

    echo $res;
}

function enviarCorreo($destino, $asunto, $msg, $altCuerpo, $raiz) {

    $correo = new Correos();

    $correo->raiz = $raiz;
    $correo->inicializar();
    $correo->setDestinatario($destino);
    $correo->armarCorreo($asunto, $msg, $altCuerpo);

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