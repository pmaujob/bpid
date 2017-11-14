<?php

class CRegistro {

    private $tipoReg;
    private $conceptoPost;
    private $motivacion;
    private $archivo;
    private $archivoText;
    private $secretario;
    private $archivoHash;
    private $numProyecto;

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

    private function crearDirectorio() {

        $rutaProyecto = "../archivos/proyectos/" . $this->getNumProyecto() . "/registro";

        try {
            if (!file_exists("$rutaProyecto")) {
                mkdir($rutaProyecto, 0777, true);
            }

            $rutaProyecto = $rutaProyecto . "/" . $this->getArchivoHash();
            move_uploaded_file($this->getArchivo()['tmp_name'], $rutaProyecto);
        } catch (Exception $e) {
            print "Error Al subir Archivo" . $e;
        }
    }

    public function registrar() {

        $this->crearDirectorio();
        return "Tipo registro: " . $this->getTipoReg() . ", Concepto: " . $this->getConceptoPost() . ", Motivacion: " . $this->getMotivacion() . ", Archivo: " . var_dump($this->getArchivo()) . ", Archivo texto: " . $this->getArchivoText() . ", Secretario: " . $this->getSecretario() . ", numero proyecto: " . $this->getNumProyecto();
    }

}

if (isset($_FILES['archivo']) && !empty($_FILES['archivo'])) {

    $cRegistro = new CRegistro();
    $cRegistro->setNumProyecto($_POST['num_proyecto']);
    $cRegistro->setTipoReg($_POST['tipo_reg']);
    $cRegistro->setConceptoPost($_POST['concepto_post']);
    $cRegistro->setMotivacion($_POST['motivacion']);
    $cRegistro->setArchivo($_FILES['archivo']);
    $cRegistro->setArchivoText($_POST['archivo_text']);
    $cRegistro->setSecretario($_POST['secretario']);
    $cRegistro->setArchivoHash(sha1_file($cRegistro->getArchivo()['tmp_name']));

    echo $cRegistro->registrar();
}
?>

