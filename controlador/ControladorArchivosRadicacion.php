<?php

require_once '../modelo/Archivos.php';
require_once '../librerias/ConexionPDO.php';

$numProyecto = $_POST['numProyecto'];
$bpid = $_POST['bpid'];
$indicesArchivosReq = explode(',', $_POST['indicesArchivosReq']);
$indicesArchivosSub = ($_POST['indicesArchivosSub'] != '' ? explode(',', $_POST['indicesArchivosSub']) : null);
$dirSubidaReq = "../archivos/proyectos/$numProyecto/requisitos/";
$dirSubidaSub = "../archivos/proyectos/$numProyecto/subrequisitos/";

if (!file_exists("$dirSubidaReq")) {
    mkdir($dirSubidaReq, 0777, true);
}

if (!file_exists("$dirSubidaSub")) {
    mkdir($dirSubidaSub, 0777, true);
}

for ($i = 0; $i < count($indicesArchivosReq); $i += 2) {//incremento en +2 ya que el arreglo viene con requisito y contador de pregunta
    $ar = $_FILES['REQFILE' . $indicesArchivosReq[$i + 1]];
    $nombreArchivoReq = basename($ar['name']);
    $archivoReq = $dirSubidaReq . $nombreArchivoReq;
    $shareq = sha1_file($ar['tmp_name']);

    if (move_uploaded_file($ar['tmp_name'], $archivoReq)) {

        $objetoArchivoReq = new Archivos();
        $objetoArchivoReq->setRuta($archivoReq);
        $objetoArchivoReq->setNombreArchivo($nombreArchivoReq);
        $objetoArchivoReq->setNombreRealArchivo($nombreArchivoReq);
        $objetoArchivoReq->setCodBpid($bpid);
        $objetoArchivoReq->setHashNum($shareq);
        $objetoArchivoReq->setCodEtapa($indicesArchivosReq[$i]);
        $objetoArchivoReq->setTipoEtapa(Archivos::$ETAPA_REQUISITO);
        Archivos::guardarDatosArchivo($objetoArchivoReq);
    } else {
        echo "¡Error al subir uno de los adjuntos!\n";
    }
}

for ($i = 0; $i < count($indicesArchivosSub); $i += 2) {//incremento en +2 ya que el arreglo viene con requisito y contador de pregunta
    $as = $_FILES['SUBFILE' . $indicesArchivosSub[$i + 1]];
    $nombreArchivoSub = basename($as['name']);
    $archivoSub = $dirSubidaSub . $nombreArchivoSub;
    $shasub = sha1_file($as['tmp_name']);

    if (move_uploaded_file($as['tmp_name'], $archivoSub)) {

        $objetoArchivoSub = new Archivos();
        $objetoArchivoSub->setRuta($archivoSub);
        $objetoArchivoSub->setNombreArchivo($nombreArchivoSub);
        $objetoArchivoSub->setNombreRealArchivo($nombreArchivoSub);
        $objetoArchivoSub->setCodBpid($bpid);
        $objetoArchivoReq->setHashNum($shasub);
        $objetoArchivoSub->setCodEtapa($indicesArchivosSub[$i]);
        $objetoArchivoSub->setTipoEtapa(Archivos::$ETAPA_SUBREQUISITO);
        Archivos::guardarDatosArchivo($objetoArchivoSub);
    } else {
        echo "¡Error al subir uno de los adjuntos!\n";
    }
}
?>

