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

        return MActualizarActividades::actualizarActividades($idRad, CambiarFormatos::convertirAJsonItems($newArray));
    }
     function actProductos($unidadesMedida) {

        $newArrayUnidad = array();

        foreach ($unidadesMedida as $unidad) {
            $newUnidad = array("idPro" => $unidad[0],"numero" => $unidad[1], "unidad" => $unidad[2]);
            $newArrayUnidad[] = $newUnidad;
        }

        return MActualizarActividades::actualizarUnidades(CambiarFormatos::convertirAJsonItems($newArrayUnidad));
       // return  var_dump(CambiarFormatos::convertirAJsonItems($newArrayUnidad));
    }

}

$metaActividades = array();
$metaActividades = $_POST['metaActividades'];
$unidadesMedida = array();
$unidadesMedida = $_POST['unidades'];
$idRad = $_POST['idRad'];
$radicacionActividades = new RadicacionActividades();

if( $radicacionActividades->actProductos($unidadesMedida)==1)
{
echo $radicacionActividades->actualizar($idRad, $metaActividades);
}
else
{
    echo 0;
}
?>
