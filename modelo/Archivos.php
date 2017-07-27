<?php

class Archivos {

    private $codArchivo;
    private $ruta;
    private $nombreArchivo;
    private $nombreRealArchivo;
    private $numeroPrograma;
    private $numeroProyecto;
    private $codBpid;
    private $fechaCreacion;
    private $horaCreacion;
    private $codActivacion;
    private $hashNum;
    private $codEtapa;
    private $tipoEtapa;
    //MGA
    public static $ETAPA_BPID = 1;
    //Radicación
    public static $ETAPA_REQUISITO = 2;
    public static $ETAPA_SUBREQUISITO = 3; //********ULTIMO

    public function getCodArchivo() {
        return $this->codArchivo;
    }

    public function getRuta() {
        return $this->ruta;
    }

    public function getNombreArchivo() {
        return $this->nombreArchivo;
    }

    public function getNombreRealArchivo() {
        return $this->nombreRealArchivo;
    }

    public function getNumeroPrograma() {
        return $this->numeroPrograma;
    }

    public function getNumeroProyecto() {
        return $this->numeroProyecto;
    }

    public function getCodBpid() {
        return $this->codBpid;
    }

    public function getFechaCreacion() {
        return $this->fechaCreacion;
    }

    public function getHoraCreacion() {
        return $this->horaCreacion;
    }

    public function getCodActivacion() {
        return $this->codActivacion;
    }

    public function getHashNum() {
        return $this->hashNum;
    }

    public function getCodEtapa() {
        return $this->codEtapa;
    }

    public function getTipoEtapa() {
        return $this->tipoEtapa;
    }

    public function setCodArchivo($codArchivo) {
        $this->codArchivo = $codArchivo;
    }

    public function setRuta($ruta) {
        $this->ruta = $ruta;
    }

    public function setNombreArchivo($nombreArchivo) {
        $this->nombreArchivo = $nombreArchivo;
    }

    public function setNombreRealArchivo($nombreRealArchivo) {
        $this->nombreRealArchivo = $nombreRealArchivo;
    }

    public function setNumeroPrograma($numeroPrograma) {
        $this->numeroPrograma = $numeroPrograma;
    }

    public function setNumeroProyecto($numeroProyecto) {
        $this->numeroProyecto = $numeroProyecto;
    }

    public function setCodBpid($codBpid) {
        $this->codBpid = $codBpid;
    }

    public function setFechaCreacion($fechaCreacion) {
        $this->fechaCreacion = $fechaCreacion;
    }

    public function setHoraCreacion($horaCreacion) {
        $this->horaCreacion = $horaCreacion;
    }

    public function setCodActivacion($codActivacion) {
        $this->codActivacion = $codActivacion;
    }

    public function setHashNum($hastNum) {
        $this->hashNum = $hastNum;
    }

    public function setCodEtapa($codEtapa) {
        $this->codEtapa = $codEtapa;
    }

    public function setTipoEtapa($tipoEtapa) {
        $this->tipoEtapa = $tipoEtapa;
    }

    public static function guardarDatosArchivo($objetoArchivo) {

        $sql = "select from ing_datos_archivo("
                . "'" . $objetoArchivo->getRuta() . "'"
                . ",'" . $objetoArchivo->getNombreArchivo() . "'"
                . ",'" . $objetoArchivo->getNombreRealArchivo() . "'"
                . "," . ($objetoArchivo->getNumeroPrograma() == null ? 'null' : "'" . $objetoArchivo->getNumeroPrograma() . "'")
                . "," . ($objetoArchivo->getNumeroProyecto() == null ? 'null' : "'" . $objetoArchivo->getNumeroProyecto() . "'")
                . "," . $objetoArchivo->getCodBpid() . ""
                . ",'" . $objetoArchivo->getHashNum() . "'"
                . "," . $objetoArchivo->getCodEtapa()
                . "," . $objetoArchivo->getTipoEtapa() . ");";

        
        $con = new ConexionPDO();
        $con->conectar("PG");        
        $resultado = $con->consultar($sql);
        $con->cerrarConexion();
        
    }

}
?>

