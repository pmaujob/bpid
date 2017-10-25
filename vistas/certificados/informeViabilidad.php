<?php

date_default_timezone_set('America/Bogota');
session_start();
require_once '../../librerias/fpdf/fpdf.php';
require_once '../../librerias/fpdf/PDF.php';
require_once '../../librerias/DisenoCertificacionesPDF.php';
require_once '../../modelo/CargarDatosCerViabilidad.php';

$datos = 1;

$datosRadicacion = CargarDatosCerViabilidad::getDatosInformeViabilidad($datos);

$pdf = new FPDF('P', 'mm', 'Letter'); // vertical, milimetros y tamaño
$pdf->SetMargins(20, 15, 20);
$pdf->AddPage();
foreach ($datosRadicacion as $row) {
    //================== Cabecera ==========================
    $pdf->Image('imagenes/colombia_escudo.png', 34, 17, 13);
    $pdf->Image('imagenes/corazonmundo.png', 170, 17, 15);

    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(0, 6, utf8_decode('SECRETARIA DE PLANEACIÓN DEPARTAMENTAL'), 0, 0, 'C');
    $pdf->Ln(5);
    $pdf->Cell(0, 6, utf8_decode('BANCO DE PROGRAMAS Y PROYECTOS'), 0, 0, 'C');
    $pdf->Ln(5);
    $pdf->Cell(0, 6, utf8_decode('DE INVERSIÓN DEPARTAMENTAL'), 0, 0, 'C');
    $pdf->Ln(5);
    $pdf->Cell(40, 6, utf8_decode('Républica de Colombia'), 0, 0, 'C');
    $pdf->Ln(0);
    $pdf->Cell(0, 6, utf8_decode('BPID'), 0, 0, 'C');
    $pdf->Ln(3);
    $pdf->Cell(20, 3, '_______________________________________________________________________________________________________________');
    $pdf->Ln(2);
    $pdf->SetFont('Arial', 'B', 6);
    $pdf->Cell(10, 6, utf8_decode('Código Formato: BPID-IV01'));
    $pdf->Ln(0);
    $pdf->Cell(0, 6, utf8_decode('Versión: 02'), 0, 0, 'C');
    $pdf->Ln(0);
    $pdf->Cell(0, 6, utf8_decode('Fecha Formato: ' . date("d/M/Y")), 0, 0, 'R');

    //================== Cuerpo ==========================
    $pdf->Ln(10);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(0, 6, utf8_decode('INFORME DE VIABILIDAD'), 0, 0, 'C');
    $pdf->Ln(10);
    $pdf->Cell(0, 6, utf8_decode('Código de Radicación:'));
    $pdf->Ln(0);
    $pdf->Cell(0, 6, utf8_decode('Fecha de Viabilidad:'), 0, 0, 'C');
    $pdf->Ln(0);
    $pdf->Cell(0, 6, utf8_decode('Hora de Viabilidad:'), 0, 0, 'R');

//================== Datos a Reemplazar ===============
    $pdf->Ln(4);
    $pdf->Cell(0, 6, $row[0]);
    $pdf->Ln(0);
    $pdf->Cell(0, 6, utf8_decode(date("d/M/Y")), 0, 0, 'C');
    $pdf->Ln(0);
    $pdf->Cell(0, 6, utf8_decode('10:08:56'), 0, 0, 'R');

    $pdf->Ln(10);
    $pdf->Cell(0, 6, utf8_decode('Nombre del Programa o Proyecto:'));
    $pdf->Ln(5);
    DisenoCertificacionesPDF::justificarParrafo(utf8_decode($row[1]), 0.965, $pdf); //*************
    $pdf->Ln(10);
    $pdf->Cell(60, 6, utf8_decode('Entidad Proponente:'));
    $pdf->Cell(60, 6, utf8_decode($row[2]), 0, 0); //*************
    $pdf->Ln(10);
    $pdf->Cell(60, 6, utf8_decode('Entidad Ejecutora:'));
    $pdf->Cell(60, 6, utf8_decode($row[3]), 0, 0); //*************
    $pdf->Ln(10);
    $pdf->Cell(60, 6, utf8_decode('Eje Estratégico:'));
    $pdf->Cell(60, 6, utf8_decode(ucfirst($row[4])), 0, 0); //*************
    $pdf->Ln(5);
    $pdf->Cell(60, 6, utf8_decode('Programa:'));
    $strPrograma = ucfirst(substr($row[5], 2, strlen($row[5]) - 4));
    DisenoCertificacionesPDF::justificarParrafo(utf8_decode($strPrograma), 1.46, $pdf); //*************
    $pdf->Cell(60, 6, utf8_decode('Subprograma:'));
    $strSub = ucfirst(substr($row[6], 2, strlen($row[6]) - 4));
    DisenoCertificacionesPDF::justificarParrafo(utf8_decode($strSub), 1.46, $pdf); //*************
    $pdf->Ln(5);
    $pdf->Cell(60, 6, utf8_decode('Problema central o necesidad:'));
    $pdf->Ln(5);
    DisenoCertificacionesPDF::justificarParrafo(utf8_decode(ucfirst($row[7])), 0.965, $pdf); //*************
    $pdf->Ln(5);
    $pdf->Cell(60, 6, utf8_decode('Objetivo general:'));
    $pdf->Ln(5);
    DisenoCertificacionesPDF::justificarParrafo(utf8_decode(ucfirst($row[8])), 0.965, $pdf); //*************
    $pdf->Ln(5);
    $pdf->Cell(60, 6, utf8_decode('Objetivos específicos:'));
    $pdf->Ln(5);

    $obEspecificos = CargarDatosCerViabilidad::getObjetivosEspecificos($row[9]);
    $i = 1;

    foreach ($obEspecificos as $ob) {
        DisenoCertificacionesPDF::justificarParrafo(utf8_decode("$i. " . ucfirst($ob[1])), 0.965, $pdf); //*************
        $i++;
    }

    /* INSERTAR PRODUCTOS */

    $pdf->Ln(5);
    $pdf->Cell(60, 6, utf8_decode('Descripción del programa o proyecto:'));
    $pdf->Ln(5);
    DisenoCertificacionesPDF::justificarParrafo(utf8_decode(ucfirst($row[10])), 0.965, $pdf); //*************

    break;
}
$pdf->Output();
?>
