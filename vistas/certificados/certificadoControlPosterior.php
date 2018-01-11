<?php

date_default_timezone_set('America/Bogota');

@session_start();

$raiz = $_SESSION['raiz'];
$raizHtml = $_SESSION['raizHtml'];

require_once $raiz . '/librerias/fpdf/fpdf.php';
require_once $raiz . '/librerias/fpdf/PDF.php';
require_once $raiz . '/librerias/DisenoCertificacionesPDF.php';
require_once $raiz . '/modelo/MGetDatosCertificadoPosterior.php';
require_once $raiz . '/librerias/CambiarFormatos.php';
require_once $raiz . '/librerias/SessionVars.php';

$sess = new SessionVars();

$idRad = $_GET['idRad'];
$codBpid = $_GET['codBpid'];
const etapa = 6;

$datos = MGetDatosCertificadoPosterior::getDatos($idRad)->fetch(PDO::FETCH_OBJ);

$pdf = new FPDF('P', 'mm', 'Letter'); // vertical, milimetros y tamaño
$pdf->SetMargins(20, 15, 20);
$pdf->AddPage();
//================== Cabecera ==========================
$pdf->Image('imagenes/colombia_escudo.png', 34, 17, 13); //left,top,size
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
$pdf->Cell(10, 6, utf8_decode('Código Formato: BPID-IV01'));
$pdf->Ln(0);
$pdf->Cell(0, 6, utf8_decode('Versión: 02'), 0, 0, 'C');
$pdf->Ln(0);
$pdf->Cell(0, 6, utf8_decode('Fecha Formato: ' . date("d/M/Y")), 0, 0, 'R');
$pdf->Ln(10);

$pdf->Cell(0, 6, utf8_encode('INFORME DE CONTROL POSTERIOR DE VIABILIDAD'), 0, 0, 'C');
$pdf->Ln(10);

$pdf->Cell(34, 6, utf8_decode('Código de Radicación: '), 0, 0);
$pdf->Cell(56, 6, $datos->num, 0, 0);
$pdf->Cell(34, 6, utf8_decode('Fecha Radicación: '), 0, 0);
$pdf->Cell(0, 6, CambiarFormatos::cambiarFecha($datos->fece), 0, 0);

$pdf->Ln(9);

$pdf->Cell(34, 6, 'Fecha de Viabilidad: ', 0, 0);
$pdf->Cell(56, 6, CambiarFormatos::cambiarFecha($datos->fvia), 0, 0);
$pdf->Cell(34, 6, 'Fecha Ingreso BPID: ', 0, 0);
$pdf->Cell(0, 6, CambiarFormatos::cambiarFecha($datos->fece), 0, 0);

$pdf->Ln(9);

$pdf->Cell(34, 6, 'Tipo de Registro: ', 0, 0);
$pdf->Cell(56, 6, utf8_decode($datos->tip), 0, 0);

$pdf->Ln(9);

$pdf->Cell(90, 6, utf8_decode('Secretaría Sectorial o Instituto Descentralizado: '), 0, 0);
$pdf->Cell(34, 6, utf8_decode($datos->sec), 0, 0);

$pdf->Ln(9);

$pdf->Cell(34, 6, 'Nombre del Programa o Proyecto: ', 0, 0);
$pdf->Ln(4);
$pdf->MultiCell(0, 4, utf8_decode($datos->nom));

$pdf->Ln(9);

$pdf->Cell(34, 6, 'Entidad Proponente: ', 0, 0);
$pdf->Cell(56, 6, utf8_decode($datos->enti), 0, 0);

$pdf->Ln(9);

$pdf->Cell(34, 6, 'Entidad Ejecutora: ', 0, 0);
$pdf->Cell(56, 6, utf8_decode($datos->ente), 0, 0);

$pdf->Ln(9);

$pdf->Cell(46, 6, 'Costo del Programa o Proyecto: ', 0, 0);
$pdf->Cell(69, 6, $datos->val, 0, 0);

$pdf->Ln(9);

$pdf->Cell(34, 6, utf8_decode('Motivación de la Viabilidad: '), 0, 0);
$pdf->Ln(4);
$pdf->MultiCell(0, 4, utf8_decode($datos->mot));

$pdf->Ln(9);

$pdf->Cell(90, 6, 'Concepto Control Posterior de Viabilidad: ', 0, 0);
$pdf->Cell(0, 6, utf8_decode($datos->contr), 0, 0);

$pdf->Ln(9);

$pdf->Cell(34, 6, 'Documentos Anexos: ', 0, 0);
$pdf->SetFont('Arial', 'U', 9);
$pdf->Cell(34, 6, utf8_decode($datos->arch), 0, 0);

$pdf->Ln(20);
$pdf->Cell(106, 6, "_________________________________________", 0, 0);
$pdf->Ln();
$pdf->SetFont('Arial', '', 11);
$pdf->Cell(0, 6, $sess->getValue('usuario'), 0, 0);
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(0, 6, "Funcionario Responsable", 0, 0);

$pdf->Output();

?>