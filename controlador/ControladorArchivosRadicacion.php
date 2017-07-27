<?php

require_once '../modelo/Archivos.php';
require_once '../librerias/ConexionPDO.php';

$numProyecto = $_POST['numProyecto'];
$bpid = $_POST['bpid'];
$idRad = $_POST['idRad'];
$totalArchivosReq = explode(',', $_POST['totalArchivosReq']);
$totalArchivosSub = ($_POST['totalArchivosSub'] != '' ? explode(',', $_POST['totalArchivosSub']) : null);

$dirSubidaReq = "../archivos/proyectos/$numProyecto/requisitos/";
$dirSubidaSub = "../archivos/proyectos/$numProyecto/subrequisitos/";

$fallidosReq = array();
$fallidosSub = array();

if (!file_exists("$dirSubidaReq")) {
    mkdir($dirSubidaReq, 0777, true);
}

if (!file_exists("$dirSubidaSub")) {
    mkdir($dirSubidaSub, 0777, true);
}

for ($i = 0; $i < count($totalArchivosReq); $i += 2) {//incremento en +2 ya que el arreglo viene con requisito y contador de pregunta
    $ar = $_FILES['REQFILE' . $totalArchivosReq[$i + 1]];
    $nombreArchivoReq = basename($ar['name']);
    $archivoReq = $dirSubidaReq . $nombreArchivoReq;
    $shareq = sha1_file($ar['tmp_name']);

    if (move_uploaded_file($ar['tmp_name'], $archivoReq)) {

        $objetoArchivoReq = new Archivos();
        $objetoArchivoReq->setRuta($archivoReq);
        $objetoArchivoReq->setNombreArchivo($nombreArchivoReq);
        $objetoArchivoReq->setNombreRealArchivo($nombreArchivoReq);
        $objetoArchivoReq->setNumeroProyecto($numProyecto);
        $objetoArchivoReq->setCodBpid($bpid);
        $objetoArchivoReq->setHashNum($shareq);
        $objetoArchivoReq->setCodEtapa($totalArchivosReq[$i]);
        $objetoArchivoReq->setTipoEtapa(Archivos::$ETAPA_REQUISITO);
        $objetoArchivoReq->setCodRadicacion($idRad);
        Archivos::guardarDatosArchivo($objetoArchivoReq);
    } else {
        $fallidosReq[] = array("requisito" => $totalArchivosReq[$i], "nPreguntaReq" => $totalArchivosReq[$i + 1]);
    }
}

for ($i = 0; $i < count($totalArchivosSub); $i += 2) {//incremento en +2 ya que el arreglo viene con requisito y contador de pregunta
    $as = $_FILES['SUBFILE' . $totalArchivosSub[$i + 1]];
    $nombreArchivoSub = basename($as['name']);
    $archivoSub = $dirSubidaSub . $nombreArchivoSub;
    $shasub = sha1_file($as['tmp_name']);

    if (move_uploaded_file($as['tmp_name'], $archivoSub)) {

        $objetoArchivoSub = new Archivos();
        $objetoArchivoSub->setRuta($archivoSub);
        $objetoArchivoSub->setNombreArchivo($nombreArchivoSub);
        $objetoArchivoSub->setNombreRealArchivo($nombreArchivoSub);
        $objetoArchivoSub->setNumeroProyecto($numProyecto);
        $objetoArchivoSub->setCodBpid($bpid);
        $objetoArchivoSub->setHashNum($shasub);
        $objetoArchivoSub->setCodEtapa($totalArchivosSub[$i]);
        $objetoArchivoSub->setTipoEtapa(Archivos::$ETAPA_SUBREQUISITO);
        $objetoArchivoSub->setCodRadicacion($idRad);
        Archivos::guardarDatosArchivo($objetoArchivoSub);
    } else {
        $fallidosSub[] = array("subRequisito" => $totalArchivosSub[$i], "nPreguntaSub" => $totalArchivosSub[$i + 1]);
    }
}

echo json_encode($fallidosReq) . "|" . json_encode($fallidosSub);

?>

