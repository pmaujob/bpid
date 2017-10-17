<?php

require '../librerias/CambiarFormatos.php';
include_once '../librerias/SessionVars.php';
$sess = new SessionVars();
$sess->init();
$correcto = 1; //control de datos archivo Xml

class CConsutarDatosXml {

    private $nombreArchivo;
    private $rutaArchivo;
    private $extencion;
    private $datosProyecto;
    private $nombrep;
    private $numero_proyecto;
    private $sector;
    private $problema;
    private $departamento;
    private $municipio;
    private $poblacion;
    private $eje;
    private $programa;
    private $subprograma;
    private $objetivo;
    private $Decision;
    private $monto = array();
    private $detalle = array();
    private $periodo = array();
    private $indice = 0;
    private $val = 0;
    private $total = 0;

    public function getNombreArchivo() {
        return $this->nombreArchivo;
    }

    public function getRutaArchivo() {
        return $this->rutaArchivo;
    }

    public function getExtencion() {
        return $this->extencion;
    }

    public function getDatosProyecto() {
        return $this->datosProyecto;
    }

    public function getNombrep() {
        return $this->nombrep;
    }

    public function getNumero_proyecto() {
        return $this->numero_proyecto;
    }

    public function getSector() {
        return $this->sector;
    }

    public function getProblema() {
        return $this->problema;
    }

    public function getDepartamento() {
        return $this->departamento;
    }

    public function getMunicipio() {
        return $this->municipio;
    }

    public function getPoblacion() {
        return $this->poblacion;
    }

    public function getEje() {
        return $this->eje;
    }

    public function getPrograma() {
        return $this->programa;
    }

    public function getSubprograma() {
        return $this->subprograma;
    }

    public function getObjetivo() {
        return $this->objetivo;
    }

    public function getDecision() {
        return $this->Decision;
    }

    public function getMonto() {
        return $this->monto;
    }

    public function getDetalle() {
        return $this->detalle;
    }

    public function getPeriodo() {
        return $this->periodo;
    }

    public function getIndice() {
        return $this->indice;
    }

    public function getVal() {
        return $this->val;
    }

    public function getTotal() {
        return $this->total;
    }

    public function setNombreArchivo($nombreArchivo) {
        $this->nombreArchivo = $nombreArchivo;
    }

    public function setRutaArchivo($rutaArchivo) {
        $this->rutaArchivo = $rutaArchivo;
    }

    public function setExtencion($extencion) {
        $this->extencion = $extencion;
    }

    public function setDatosProyecto($datosProyecto) {
        $this->datosProyecto = $datosProyecto;
    }

    public function setNombrep($nombrep) {
        $this->nombrep = $nombrep;
    }

    public function setNumero_proyecto($numero_proyecto) {
        $this->numero_proyecto = $numero_proyecto;
    }

    public function setSector($sector) {
        $this->sector = $sector;
    }

    public function setProblema($problema) {
        $this->problema = $problema;
    }

    public function setDepartamento($departamento) {
        $this->departamento = $departamento;
    }

    public function setMunicipio($municipio) {
        $this->municipio = $municipio;
    }

    public function setPoblacion($poblacion) {
        $this->poblacion = $poblacion;
    }

    public function setEje($eje) {
        $this->eje = $eje;
    }

    public function setPrograma($programa) {
        $this->programa = $programa;
    }

    public function setSubprograma($subprograma) {
        $this->subprograma = $subprograma;
    }

    public function setObjetivo($objetivo) {
        $this->objetivo = $objetivo;
    }

    public function setDecision($Decision) {
        $this->Decision = $Decision;
    }

    public function setMonto($monto) {
        $this->monto = $monto;
    }

    public function setDetalle($detalle) {
        $this->detalle = $detalle;
    }

    public function setPeriodo($periodo) {
        $this->periodo = $periodo;
    }

    public function setIndice($indice) {
        $this->indice = $indice;
    }

    public function setVal($val) {
        $this->val = $val;
    }

    public function setTotal($total) {
        $this->total = $total;
    }

    public function asignarValores($rutaArchivo, $nombreArchivo) {
        $trozos = explode(".", $nombreArchivo);
        $extension = end($trozos); 
    }

}

$consulta = new CConsutarDatosXml();
$consulta->setRutaArchivo($_FILES['frm_archivo']['tmp_name']);
$consulta->setNombreArchivo($_FILES['frm_archivo']['name']);
?>