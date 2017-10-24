<?php

require_once '../librerias/CambiarFormatos.php';

$metaActividades = array();
$metaActividades = $_POST['metaActividades'];

$newArray = array();
foreach ($metaActividades as $meta) {
    $newRow = array("idAct" => $meta[0], "idMeta" => $meta[1]);

    $newArray[] = $newRow;
}

echo CambiarFormatos::convertirAJsonItems($newArray);

?>
