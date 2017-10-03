<?php

date_default_timezone_set('America/Bogota');
session_start();
require_once '../../librerias/fpdf/fpdf.php';
require_once '../../librerias/fpdf/PDF.php';
require_once '../../librerias/DisenoCertificacionesPDF.php';

//$datos = new ObtenerDatosCertificadoRadicar();

$pdf = new FPDF('P', 'mm', 'Letter'); // vertical, milimetros y tamaño
$pdf->SetMargins(20, 15, 20);
$pdf->AddPage();

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
$pdf->Cell(0, 6, utf8_decode('2013-52000-0563'));
$pdf->Ln(0);
$pdf->Cell(0, 6, utf8_decode(date("d/M/Y")), 0, 0, 'C');
$pdf->Ln(0);
$pdf->Cell(0, 6, utf8_decode('10:08:56'), 0, 0, 'R');

$pdf->Ln(10);
$pdf->Cell(0, 6, utf8_decode('Nombre del Programa o Proyecto:'));
$pdf->Ln(5);
DisenoCertificacionesPDF::justificarParrafo(utf8_decode(
                'FORTALECIMIENTO DE LA IDENTIDAD CULTURAL DE LAS COMUNIDADES AFRONARIÑENSES DE LA COSTA PACÍFICA DEL DEPARTAMENTO DE NARIÑO'), 1, $pdf); //dato a reemplazar
$pdf->Ln(10);
$pdf->Cell(0, 6, utf8_decode('Entidad Proponente:'));
$pdf->Ln(0);
$pdf->Cell(80, 6, utf8_decode('Gobernación de Nariño'), 0, 0, 'R');//*************
$pdf->Ln(10);
$pdf->Cell(0, 6, utf8_decode('Entidad Ejecutora:'));
$pdf->Ln(0);
$pdf->Cell(80, 6, utf8_decode('Gobernación de Nariño'), 0, 0, 'R');//*************

$pdf->Output();
?>
