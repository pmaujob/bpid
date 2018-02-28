<?php
@session_start();

$raiz = $_SESSION['raiz'];

require_once $raiz . '/modelo/MRegistro.php';
require_once $raiz . '/librerias/CambiarFormatos.php';
require_once $raiz . '/librerias/Correos.php';
require_once $raiz . '/librerias/SessionVars.php';
require_once $raiz . '/modelo/CargarRadicados.php';

class CRegistro {

    private $tipoReg;
    private $conceptoPost;
    private $motivacion;
    private $archivo;
    private $archivoText;
    private $secretario;
    private $archivoHash;
    private $numProyecto;
    private $idRad;
    public $raiz;

    private function getTipoReg() {
        return $this->tipoReg;
    }

    private function getConceptoPost() {
        return $this->conceptoPost;
    }

    private function getMotivacion() {
        return $this->motivacion;
    }

    public function getArchivo() {
        return $this->archivo;
    }

    private function getArchivoText() {
        return $this->archivoText;
    }

    private function getSecretario() {
        return $this->secretario;
    }

    private function getArchivoHash() {
        return $this->archivoHash;
    }

    private function getNumProyecto() {
        return $this->numProyecto;
    }

    private function getIdRad() {
        return $this->idRad;
    }

    public function setTipoReg($tipoReg) {
        $this->tipoReg = $tipoReg;
    }

    public function setConceptoPost($conceptoPost) {
        $this->conceptoPost = $conceptoPost;
    }

    public function setMotivacion($motivacion) {
        $this->motivacion = $motivacion;
    }

    public function setArchivo($archivo) {
        $this->archivo = $archivo;
    }

    public function setArchivoText($archivoText) {
        $this->archivoText = $archivoText;
    }

    public function setSecretario($secretario) {
        $this->secretario = $secretario;
    }

    public function setArchivoHash($archivoHash) {
        $this->archivoHash = $archivoHash;
    }

    public function setNumProyecto($numProyecto) {
        $this->numProyecto = $numProyecto;
    }

    public function setIdRad($idRad) {
        $this->idRad = $idRad;
    }

    private function crearDirectorio() {

        $rutaProyecto = "../archivos/proyectos/" . $this->getNumProyecto() . "/registro";

        try {
            if (!file_exists("$rutaProyecto")) {
                mkdir($rutaProyecto, 0777, true);
            }

            $rutaProyecto = $rutaProyecto . "/" . $this->getArchivo()['name'];
            move_uploaded_file($this->getArchivo()['tmp_name'], $rutaProyecto);
        } catch (Exception $e) {
            print "Error Al subir Archivo" . $e;
        }
    }

    public function registrar() {

        $this->crearDirectorio();
        $res = MRegistro::registrar($this->getTipoReg(), $this->getConceptoPost(), $this->getMotivacion(), $this->getArchivo()['name'] == '' ? NULL : $this->getArchivo()['name'], $this->getArchivoHash() == '' ? NULL : $this->getArchivoHash(), $this->getIdRad(), $this->getSecretario());

        $sess = new SessionVars();
        $sess->init();
        $datosProyecto = CargarRadicados::getDatosProyecto($this->idRad)->fetch(PDO::FETCH_BOTH);

        if ($res == 1) {

            $asunto = utf8_encode("Radicación Proyecto Bpid");
            ob_start();
            ?>
            <span><strong>Estimado <?php echo $sess->getValue('usuario')?></strong></span> 
            <br>
            <p style="text-align: justify;">Informamos que su proyecto <strong><?php echo $datosProyecto[3] . " "; ?></strong> 
                con número BPID <strong><?php echo $datosProyecto[1]; ?></strong>, en la fecha <?php CambiarFormatos::cambiarFecha(date("m/d/Y")); ?>,
                fue <strong>registrado con éxito.</strong>          
            </p>
            <?php
            $msg = ob_get_clean();
            $altCuerpo = nl2br("Estimado " . $sess->getValue('usuario') . "."
                    . "\n\nInformamos que su proyecto " . $datosProyecto[3]
                    . "con número BPID " . $datosProyecto[1] . " cumplió "
                    . "con los requisitos de las listas de chequeo, y por ende, fue radicado con éxito. "
                    . "\n\n* Este es un email que se ha generado automáticamente, por favor no lo responda *"
                    . "\n\nSí no tiene conocimiento sobre el tema, por favor ignore este mensaje.");

            $correo = new Correos();
            $correo->raiz = $this->raiz;
            $correo->inicializar();
            $correo->setDestinatario($sess->getValue('correo'));
            $correo->armarCorreo($asunto, $msg, $altCuerpo);
            $correo->enviar();
        }

        return $res;
    }

}

$cRegistro = new CRegistro();
$cRegistro->setNumProyecto($_POST['num_proyecto']);
$cRegistro->setTipoReg($_POST['tipo_reg']);
$cRegistro->setConceptoPost($_POST['concepto_post']);
$cRegistro->setMotivacion($_POST['motivacion']);
$cRegistro->setArchivo($_FILES['archivo']);
$cRegistro->setArchivoText($_POST['archivo_text']);
$cRegistro->setSecretario($_POST['secretario']);
$cRegistro->setIdRad($_POST['idRad']);
$cRegistro->getArchivo()['tmp_name'] == '' ? $cRegistro->setArchivoHash(NULL) : $cRegistro->setArchivoHash(sha1_file($cRegistro->getArchivo()['tmp_name']));
$cRegistro->raiz = $raiz;

echo $cRegistro->registrar();
?>

