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
    private $indiceFuente = 0;
    private $valFuente = 0;
    private $total = 0;
    private $infomacionFuentes = array();
    private $infomacionProductos = array();
    private $infomacionActividades = array();
    private $infomacionObjetivosEspecificos = array();
    private $correcto;
    
    public function getCorrecto() {
        return $this->correcto;
    }
    public function setCorrecto($correcto) {
        $this->correcto = $correcto;
    }

        
    public function getInfomacionObjetivosEspecificos() {
        return $this->infomacionObjetivosEspecificos;
    }

    public function setInfomacionObjetivosEspecificos($infomacionObjetivosEspecificos) {
        $this->infomacionObjetivosEspecificos = $infomacionObjetivosEspecificos;
    }

    public function setInfomacionProductos($infomacionProductos) {
        $this->infomacionProductos = $infomacionProductos;
    }

    public function setInfomacionActividades($infomacionActividades) {
        $this->infomacionActividades = $infomacionActividades;
    }

    public function getInfomacionProductos() {
        return $this->infomacionProductos;
    }

    public function getInfomacionActividades() {
        return $this->infomacionActividades;
    }

    public function getInfomacionFuentes() {
        return $this->infomacionFuentes;
    }

    public function setInfomacionFuentes($infomacionFuentes) {
        $this->infomacionFuentes = $infomacionFuentes;
    }

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

    public function setIndice($indiceFuente) {
        $this->indice = $indiceFuente;
    }

    public function setVal($valFuente) {
        $this->val = $valFuente;
    }

    public function setTotal($total) {
        $this->total = $total;
    }

    public function asignarValores() {
        $this->correcto = 1;
        $this->setDatosProyecto(simplexml_load_file($this->getRutaArchivo()));
        $this->setNombrep((string) $this->getDatosProyecto()->Name);
        $this->setNumero_proyecto((string) $this->getDatosProyecto()->Id);
        $this->setSector((string) $this->getDatosProyecto()->Sector->Description);
        $this->setProblema((string) $this->getDatosProyecto()->CentralProblem->CentralProblem);
        $this->setDepartamento((string) $this->getDatosProyecto()->Localizations->Localization[1]->Department->Name);
        $this->setMunicipio((string) $this->getDatosProyecto()->Localizations->Localization[1]->SpecificLocalization);
        $this->setPoblacion((string) $this->getDatosProyecto()->ObjectivePeople);
        $this->setEje((string) $this->getDatosProyecto()->PublicationContribution->Strategy);
        $this->setPrograma((string) $this->getDatosProyecto()->PublicationContribution->ProgramDescription);
        $this->setSubprograma((string) $this->getDatosProyecto()->FundingSource->ExpenseType->Description);
        $this->setObjetivo((string) $this->getDatosProyecto()->GeneralObjective->GeneralObjective);
        $this->setDecision((string) $this->getDatosProyecto()->Alternatives->Alternative->TechnicalAnalisys);
        //Datos fuentes de financiamiento
        $monto = array();
        $detalle = array();
        $periodo = array();
        $this->indiceFuente = 0;
        $this->valFuente = 0;
        $count = count($this->getDatosProyecto()->FundingSource->Sources->Source);
        if ($this->correcto == 1 && $count > 0) {
            foreach ($this->getDatosProyecto()->FundingSource->Sources->Source as $tipo) {

                $detalle[] = (string) $tipo->ResourceType->Description;
                foreach ($this->getDatosProyecto()->FundingSource->Sources->Source[$this->indiceFuente]->SourceProgrammings->SourceProgramming as $valores) {
                    $etapa = (string) $this->getDatosProyecto()->FundingSource->Sources->Source[$this->indiceFuente]->Stage->Description;

                    $tipoentidad = (string) $this->getDatosProyecto()->FundingSource->Sources->Source[$this->indiceFuente]->EntityType->EntityType;

                    $nombreEntidad = $this->getDatosProyecto()->FundingSource->Sources->Source[$this->indiceFuente]->EntityTypeCatalogOption->Name;
                    if ($nombreEntidad == "") {
                        $nombreEntidad = -1;
                    } else {
                        $nombreEntidad = tildes($nombreEntidad);
                    }
                    $monto[] = (string) $valores->Amount;
                    $total = $total + $monto[$this->valFuente];
                    $periodo[] = (string) $valores->Period;
                    $informacion_fuentes[$this->valFuente] = array("Origen" => $detalle[$this->indiceFuente], "Valor" => $monto[$this->valFuente], "Periodo" => $periodo[$this->valFuente], "Etapa" => $etapa, "Tentidad" => $tipoentidad, "Nentidad" => $nombreEntidad);
                    $this->valFuente ++;
                }
                $this->indiceFuente ++;
            }
            $this->setInfomacionFuentes($informacion_fuentes);
            $total = number_format($total, 0, '', '.');
            $this->setTotal($total);
        } else {
            $this->correcto = 2;
        }
        //fin de fuentes de financiamiento
//	INFORMACION DE LAS ACTIVIDADES DEL PROYECTO
        $actividades = array();
        $numpro = 0;
        $numact = 0;

        $num_elementos = count($this->getDatosProyecto()->Alternatives->Alternative->Products->Product);

        if ($this->correcto== 1 && $num_elementos != 0) {

            foreach ($this->getDatosProyecto()->Alternatives->Alternative->Products->Product as $producto) {
                $actividades[] = (string) $producto->ProductName;
                $valorpro = (string) $producto->Amount;

                $informacionProductos[$numpro] = array("id_producto" => $numpro, "producto" => $actividades[$numpro], "cantidad" => $valorpro);

                foreach ($this->getDatosProyecto()->Alternatives->Alternative->Products->Product[$numpro]->Activities->Activity as $actividad) {
                    //echo $numact;
                    $nombreact[] = (string) $actividad->Name;
                    $costo[] = (string) $actividad->Cost;
                    $informacion_act[$numact] = array("id_pro" => $numpro, "Actividad" => $nombreact[$numact], "Costo" => $costo[$numact]);
                    $numact++;
                }

                $numpro++;
            }
            $this->setInfomacionProductos($informacionProductos);
            $this->setInfomacionActividades($informacion_act);
        } else {
            $this->correcto = 2;
        }
        //INFORMACION DE LOS OBJETIVOS ESPECIFICOS
        $ob_especificos = array();
        $jsonespecifico = array();
        $val1 = 0;
        $numero = count($this->getDatosProyecto()->CentralProblem->Causes->Cause);
        if ($this->correcto== 1 && $numero != 0) {
            foreach ($this->getDatosProyecto()->CentralProblem->Causes->Cause as $causa) {
                $ob_especificos[] = (string) $causa->SpecificObjective->SpecificObjective;
                $jsonespecifico[$val1] = array("Objetivo" => $ob_especificos[$val1]);
                $val1++;
            }
            $this->setInfomacionObjetivosEspecificos($jsonespecifico);
        } else {
            $this->correcto = 2;
        }
       $this->setCorrecto($this->correcto);
    }
    
    
    public function extraerDatos()
    {
         if ($this->getCorrecto() == 1) {
            $jsonEs = CambiarFormatos::convertirAJsonItems($this->getInfomacionObjetivosEspecificos());
            $jsonFu = CambiarFormatos::convertirAJsonItems($this->getInfomacionFuentes());
            $jsonPro = CambiarFormatos::convertirAJsonItems($this->getInfomacionProductos());
            $jsonAct = CambiarFormatos::convertirAJsonItems($this->getInfomacionActividades());


            $datos = $this->getNombrep() . "*/" . $this->getSector() . "*/" . $this->getDepartamento() . "*/" . $this->getMunicipio() . "*/" . $this->getEje() . "*/" . $this->getProblema() . "*/" . $this->getSubprograma() . "*/" . $this->getTotal() . "*/" . $this->getNumero_proyecto() . "*/" . $jsonEs . "*/" . ($jsonFu != null ? $jsonFu : "'null'" ) . "*/" . $this->getProblema() . "*/" . $this->getPoblacion() . "*/" . $this->getObjetivo()
                    . "*/" . ($jsonPro != null ? $jsonPro : "'null'" ) . "*/" . ($jsonAct != null ? $jsonAct : "'null'" ) . "*/" . $this->getDecision();
            return $datos;
        }
        if ($this->getCorrecto() == 2) {
            return -1;
        }
    }

}

$consulta = new CConsutarDatosXml();
$consulta->setRutaArchivo($_FILES['frm_archivo']['tmp_name']);
$consulta->setNombreArchivo($_FILES['frm_archivo']['name']);
$consulta->asignarValores();
echo $consulta->extraerDatos();
?>