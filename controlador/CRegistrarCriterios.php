<?php

@session_start();

$raiz = $_SESSION['raiz'];

require_once $raiz . '/modelo/MRegistrarCriterios.php';
require_once $raiz . '/librerias/CambiarFormatos.php';

class CRegistrarCriterios {

    private $idRadicacion;
    private $preguntas = array(array(3));

    public function getIdRadicacion() {
        return $this->idRadicacion;
    }

    public function getPreguntas() {
        return $this->preguntas;
    }
    
    public function getPreguntasJson() {
        $preguntas = array();
        foreach($this->getPreguntas() as $fila){
            $aux = array("idPre" => $fila[0], "estado" => $fila[1], "obs" => $fila[2]);
            $preguntas[] = $aux;
        }
        
        $permisoJson = CambiarFormatos::convertirAJsonItems($preguntas);
        
        return $permisoJson;
        
    }

    public function setIdRadicacion($idRadicacion) {
        $this->idRadicacion = $idRadicacion;
    }

    public function setPreguntas($preguntas) {
        $this->preguntas = $preguntas;
    }

    public function registrarCriterios() {
        
        return MRegistrarCriterios::registrarCriterios($this->idRadicacion, $this->getPreguntasJson());
        
    }

}

if((isset($_POST['idRad']) && isset($_POST['preguntas'])) && (!empty($_POST['idRad']) && !empty($_POST['preguntas']))){
    
    $criterios = new CRegistrarCriterios();
    $criterios->setIdRadicacion($_POST['idRad']);
    $criterios->setPreguntas($_POST['preguntas']);
    echo $criterios->registrarCriterios();
    
}

?>

