<?php

@session_start();

$raiz = $_SESSION['raiz'];

require_once $raiz . '/modelo/MRegistrarCriterios.php';
require_once $raiz . '/librerias/CambiarFormatos.php';

class CRegistrarCriterios {

    private $idRadicacion;
    private $preguntas = array(array(2));
    private $observaciones = array(array(2));
    private $estadoObs;
    private $op;

    public function getIdRadicacion() {
        return $this->idRadicacion;
    }

    public function getPreguntas() {
        return $this->preguntas;
    }
    
    public function getObservaciones(){
        return $this->observaciones;
    }
    
    public function getEstadoObs(){
        return $this->estadoObs;
    }
    
    public function getOp() {
        return $this->op;
    }

    public function getPreguntasJson() {
        $preguntas = array();
        foreach ($this->getPreguntas() as $fila) {
            $aux = array("idPre" => $fila[0], "estado" => $fila[1]);
            $preguntas[] = $aux;
        }

        $permisoJson = CambiarFormatos::convertirAJsonItems($preguntas);

        return $permisoJson;
    }

    public function getObservacionesJson() {
        $obs = array();
        foreach ($this->getObservaciones() as $fila) {
            $aux = array("idDimen" => $fila[0], "obs" => $fila[1], "porcentaje" => $fila[2]);
            $obs[] = $aux;
        }

        $observacionesJson = CambiarFormatos::convertirAJsonItems($obs);

        return $observacionesJson;
        
    }

    public function setIdRadicacion($idRadicacion) {
        $this->idRadicacion = $idRadicacion;
    }

    public function setPreguntas($preguntas) {
        $this->preguntas = $preguntas;
    }

    public function setObservaciones($observaciones) {
        $this->observaciones = $observaciones;
    }
    
    public function setEstadoObs($estado){
        $this->estadoObs = $estado;
    }
    
    public function setOp($op) {
        $this->op = $op;
    }

    public function registrarCriterios() {

        return MRegistrarCriterios::registrarCriterios($this->idRadicacion, $this->getPreguntasJson(), $this->getEstadoObs() ? $this->getObservacionesJson() : "'null'", $this->getOp());
    }

}

if ((isset($_POST['idRad']) && isset($_POST['preguntas']) && isset($_POST['observaciones']) && isset($_POST['op'])) && (!empty($_POST['idRad']) && !empty($_POST['preguntas']) && !empty($_POST['observaciones']) && !empty($_POST['op']))) {

    $criterios = new CRegistrarCriterios();
    $criterios->setIdRadicacion($_POST['idRad']);
    $criterios->setPreguntas($_POST['preguntas']);
    $criterios->setOp($_POST['op']);
    $obs = $_POST['observaciones'];
    if($obs == "nohave") $criterios->setEstadoObs(false); else $criterios->setEstadoObs(true); $criterios->setObservaciones($obs);
    echo $criterios->registrarCriterios();
}else{
    echo var_dump($_POST['op']);
}
?>

