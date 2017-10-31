<?php

require_once '../librerias/CambiarFormatos.php';
require_once '../modelo/MActualizarActividades.php';
require_once '../librerias/ConexionPDO.php';

class RadicacionActividades {

    private $idActividad;
    private $idProducto;
    private $descripcion;
    private $valor;
    private $codMetaProducto;

    function getIdActividad() {
        return $this->idActividad;
    }

    function getIdProducto() {
        return $this->idProducto;
    }

    function getDescripcion() {
        return $this->descripcion;
    }

    function getValor() {
        return $this->valor;
    }

    function getCodMetaProducto() {
        return $this->codMetaProducto;
    }

    function setIdActividad($idActividad) {
        $this->idActividad = $idActividad;
    }

    function setIdProducto($idProducto) {
        $this->idProducto = $idProducto;
    }

    function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    function setValor($valor) {
        $this->valor = $valor;
    }

    function setCodMetaProducto($codMetaProducto) {
        $this->codMetaProducto = $codMetaProducto;
    }

    function actualizar($idRad, $metaActividades) {

        $newArray = array();

        foreach ($metaActividades as $meta) {
            $newRow = array("idAct" => $meta[0], "idMeta" => $meta[1]);

            $newArray[] = $newRow;
        }

        echo MActualizarActividades::actualizarActividades($idRad, CambiarFormatos::convertirAJsonItems($newArray));
    }

}

$metaActividades = array();
$metaActividades = $_POST['metaActividades'];
$idRad = $_POST['idRad'];
$radicacionActividades = new RadicacionActividades();

echo $radicacionActividades->actualizar($idRad, $metaActividades);
?>
