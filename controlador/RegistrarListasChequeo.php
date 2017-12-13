<?php
@session_start();

$raiz = $_SESSION['raiz'];

require_once $raiz . '/librerias/CambiarFormatos.php';
require_once $raiz . '/modelo/MRegistrarListasChequeo.php';
require_once $raiz . '/librerias/Correos.php';

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
        $noApReq = array();
        foreach ($this->getRequisitos() as $fila) {
            $temporal = str_replace("'", "''", $fila[2]);
            $reqArray[] = array("idReq" => $fila[0], "reqOp" => $fila[1], "reqObs" => $temporal);

            if ($fila[1] == "NO") {
                $noApReq[] = array($fila[3], $temporal);
            }
        }

        $reqJson = CambiarFormatos::convertirAJsonItems($reqArray);
        $subJson = null;

        $noApSub = array();
        if ($this->getSubRequisitos() != null) {

            $subArray = array();
            foreach ($this->getSubRequisitos() as $fila) {
                $temporal = str_replace("'", "''", $fila[2]);
                $subArray[] = array("idSub" => $fila[0], "subOp" => $fila[1], "subObs" => $fila[2]);

                if ($fila[1] == "NO") {
                    $noApSub [] = array($fila[3], $temporal);
                }
            }

            $subJson = CambiarFormatos::convertirAJsonItems($subArray);
        }

        $resInsert = MRegistrarListasChequeo::registrarListasChequeo($this->getIdRad(), $reqJson, $subJson);
        if ($_POST['noCont'] != null) {
            if ($_POST['noCont'] > 0 && $resInsert == 1) {//enviar correo proyecto con items desaprobados
                $resCorreo = MRegistrarListasChequeo::getCorreoRad($this->getIdRad());
                $datosCorreo = array();
                foreach ($resCorreo as $obj) {
                    for ($i = 0; $i < 4; $i++) {
                        $datosCorreo[] = $obj[$i];
                    }
                }
                $asunto = utf8_decode("Radicación Proyecto Bpid");
                ob_start();
                ?>
                <span><strong>Estimado <?php echo $datosCorreo[1]; ?></strong></span> 
                <br>
                <p style="text-align: justify;">Informamos que su proyecto <strong><?php echo $datosCorreo[2] . " "; ?></strong> 
                    con número BPID <strong><?php echo $datosCorreo[3]; ?></strong> NO cumplió con 
                    los siguientes items de las listas de chequeo:       
                </p>
                <br>
                <?php
                if (count($noApReq) > 0) {
                    ?>
                    <span><strong>Requisitos:</strong></span>
                    <br>                      
                    <br>
                    <ul>
                        <?php
                        for ($i = 0; $i < count($noApReq); $i++) {
                            $noAp = $noApReq[$i];
                            ?>
                            <li>
                                <span><?php echo $noAp[0]; ?></span>
                                <br>
                                <span><strong>Observaciones: </strong><?php echo $noAp[1]; ?></span>
                            </li>
                            <?php
                        }
                        ?>
                    </ul>
                    <br>                      
                    <br>
                    <?php
                }
                ?>
                <?php
                if (count($noApSub) > 0) {
                    ?>
                    <span><strong>Subrequisitos:</strong></span>
                    <br>                      
                    <br>
                    <ul>
                        <?php
                        for ($i = 0; $i < count($noApSub); $i++) {
                            $noAp = $noApSub[$i];
                            ?>
                            <li>
                                <span><?php echo $noAp[0]; ?></span>
                                <br>
                                <span><strong>Observaciones: </strong><?php echo $noAp[1]; ?></span>
                            </li>
                            <?php
                        }
                        ?>
                    </ul>
                    <br>                      
                    <br>
                    <?php
                }
                ?>
                <p style="text-align: justify;">Por lo tanto, el proyecto <strong>NO</strong> fue radicado. </p>   
                <br>
                <p>Para más información por favor comunicarse con la entidad.</p>
                <?php
                $msg = ob_get_clean();
                $altCuerpo = nl2br("Estimado $datosCorreo[1]."
                        . "\n\nInformamos que su proyecto $datosCorreo[2] con número BPID $datosCorreo[3] "
                        . "NO cumplió con los siguientes items de las listas de chequeo:\n\n");

                if (count($noApReq) > 0) {
                    $altCuerpo .= nl2br("\n\nRequisitos:\n\n");
                    for ($i = 0; $i < count($noApReq); $i++) {
                        $noAp = $noApReq[$i];
                        $altCuerpo .= nl2br("- " . $noAp[0] . "\n  Observaciones: " . $noAp[1]);
                    }
                    $altCuerpo .= nl2br("\n\n");
                }

                if (count($noApSub) > 0) {
                    $altCuerpo .= nl2br("\n\nSubrequisitos:\n\n");
                    for ($i = 0; $i < count($noApSub); $i++) {
                        $noAp = $noApSub[$i];
                        $altCuerpo .= nl2br("- " . $noAp[0] . "\n  Observaciones: " . $noAp[1]);
                    }
                    $altCuerpo .= nl2br("\n\n");
                }


                $altCuerpo .= nl2br("Por lo tanto, NO fue radicado."
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
    $registrar->raiz = $raiz;
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
            con número BPID <strong><?php echo $datosCorreo[3]; ?></strong> cumplió con 
            los requisitos de las listas de chequeo, y por ende, fue <strong>radicado con éxito.</strong>          
        </p>   
        <?php
        $msg = ob_get_clean();
        $altCuerpo = nl2br("Estimado $datosCorreo[1]."
                . "\n\nInformamos que su proyecto $datosCorreo[2]"
                . "con número BPID $datosCorreo[3] cumplió "
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
