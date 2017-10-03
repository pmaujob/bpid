<?php
date_default_timezone_set('America/Bogota');
session_start();
require_once '../../librerias/fpdf/fpdf.php';
require_once '../../librerias/fpdf/PDF.php';
require_once '../../librerias/DisenoCertificacionesPDF.php';

//$datos = new ObtenerDatosCertificadoRadicar();

$pdf = new FPDF('P', 'mm', 'Letter'); // vertical, milimetros y tamaño
$pdf->SetMargins(20, 15, 40);
$pdf->AddPage();

//================== Cabecera ==========================
$pdf->Image('imagenes/colombia_escudo.png', 36, 17, 13);
$pdf->Image('imagenes/corazonmundo.png', 170, 17, 15);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(180, 6, utf8_decode('SECRETARIA DE PLANEACIÓN DEPARTAMENTAL'), 0, 0, 'C');
$pdf->Ln(5);
$pdf->Cell(180, 6, utf8_decode('BANCO DE PROGRAMAS Y PROYECTOS'), 0, 0, 'C');
$pdf->Ln(5);
$pdf->Cell(180, 6, utf8_decode('DE INVERSIÓN DEPARTAMENTAL'), 0, 0, 'C');
$pdf->Ln(5);
$pdf->Cell(45, 6, utf8_decode('Républica de Colombia'), 0, 0, 'C');
$pdf->Ln(0);
$pdf->Cell(180, 6, utf8_decode('BPID'), 0, 0, 'C');
$pdf->Ln(3);
$pdf->Cell(20, 3, '_______________________________________________________________________________________________________________');
$pdf->Ln(2);
$pdf->SetFont('Arial', 'B', 6);
$pdf->Cell(10, 6, utf8_decode('Código Formato: BPID-IV01'));
$pdf->Ln(0);
$pdf->Cell(180, 6, utf8_decode('Versión: 02'), 0, 0, 'C');
$pdf->Ln(0);
$pdf->Cell(322, 6, utf8_decode('Fecha Formato: ' . date("d/M/Y")), 0, 0, 'C');

//================== Cuerpo ==========================
$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(180, 6, utf8_decode('INFORME DE VIABILIDAD'), 0, 0, 'C');
$pdf->Ln(10);
$pdf->Cell(180, 6, utf8_decode('Código de Radicación:'));
$pdf->Ln(0);
$pdf->Cell(180, 6, utf8_decode('Fecha de Viabilidad:'), 0, 0, 'C');
$pdf->Ln(0);
$pdf->Cell(325, 6, utf8_decode('Hora de Viabilidad:'), 0, 0, 'C');


$pdf->Output();
?>
