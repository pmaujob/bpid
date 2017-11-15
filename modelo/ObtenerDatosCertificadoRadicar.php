<?php

require_once '../../librerias/ConexionPDO.php';
require_once '../../librerias/CambiarFormatos.php';

class ObtenerDatosCertificadoRadicar {

    private $codigoRadicacion;
    private $fechaRadicacion;
    private $horaRadicacion;
    private $nomProyecto;
    private $sector;
    private $localizacion;
    private $entp;
    private $eneje;
    private $responsable;
    private $idResponsable;
    private $direccion;
    private $telefono;
    private $celular;
    private $fax;
    private $correo;
    private $idusu;
    private $nomusu;
    private $observaciones;
    private $numproyecto;
    private $usuario;

    public function setDatos($cod_bpid) {
        $consulta = 'select num, fec, hor, nom, sec, loc, entp, entej, numidres, nomres, dirres, telres, cel, correo,
						idusu, nomusu, obs,proy,usuario from get_datos_certificado_radicado(' . $cod_bpid . ',-2)
						 as ("num" bigint, "fec"  varchar,"hor" varchar, "nom" varchar, "sec" varchar, "loc" varchar, "entp" varchar, "entej" varchar, "numidres" varchar, "nomres"
						 varchar, "dirres" varchar,"telres" varchar,"cel" varchar, "correo" varchar, "idusu" varchar,"nomusu" varchar,"obs" varchar,"proy" varchar,"usuario" varchar)';
        $con = new ConexionPDO();
        $con->conectar("PG");
        $res = $con->consultar($consulta);
        //if(count($res>0)){
        while ($fila = $res->fetch(PDO::FETCH_BOTH)) {
            $this->codigoRadicacion = $fila[0]; //depende consulta
            $this->fechaRadicacion = CambiarFormatos::cambiarFecha($fila[1]);
            $this->horaRadicacion = $fila[2];
            $this->nomProyecto = $fila[3];
            $this->sector = $fila[4];
            $this->localizacion = $fila[5];
            $this->entp = $fila[6];
            $this->eneje = $fila[7];
            $this->idResponsable = $fila[8];
            $this->responsable = $fila[9];
            $this->direccion = $fila[10];
            $this->telefono = $fila[11];
            $this->celular = $fila[12];
            $this->correo = $fila[13];
            $this->idusu = $fila[14];
            $this->nomusu = $fila[15];
            $this->observaciones = $fila[16];
            $this->numproyecto = $fila[17];
            $this->usuario = $fila[18];
        }


        //}
    }

    public function getCodigoRadicacion() {
        return $this->codigoRadicacion;
    }

    public function getFechaRadicacion() {
        return $this->fechaRadicacion;
    }

    public function getHoraRadicacion() {
        return $this->horaRadicacion;
    }

    public function getNomProyecto() {
        return $this->nomProyecto;
    }

    public function getSectorProyecto() {
        return $this->sector;
    }

    public function getLocProyecto() {
        return $this->localizacion;
    }

    public function getentp() {
        return $this->entp;
    }

    public function geteneje() {
        return $this->eneje;
    }

    public function getidResponsable() {
        return $this->idResponsable;
    }

    public function getresponsable() {
        return $this->responsable;
    }

    public function getdireccion() {
        return $this->direccion;
    }

    public function gettelefono() {
        if ($this->telefono == -1)
            $this->telefono = "";
        return $this->telefono;
    }

    public function getcelular() {
        if ($this->celular == -1)
            $this->celular = "";
        return $this->celular;
    }

    public function getfax() {
        if ($this->fax == -1)
            $this->fax = "";
        return $this->fax;
    }

    public function getcorreo() {
        return $this->correo;
    }

    public function getidusu() {
        return $this->idusu;
    }

    public function getnomusu() {
        return $this->nomusu;
    }

    public function getobservaciones() {
        return $this->observaciones;
    }

    function getSector() {
        return $this->sector;
    }

    function getLocalizacion() {
        return $this->localizacion;
    }

    function getNumproyecto() {
        return $this->numproyecto;
    }
    public function getUsuario() {
        return $this->usuario;
    }


}

?>