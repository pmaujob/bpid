<?php

session_start();
require_once '../../modelo/ObtenerDatosCertificadoRadicar.php';
require_once '../../librerias/fpdf/fpdf.php';
require_once '../../librerias/fpdf/PDF.php';
require_once '../../librerias/DisenoCertificacionesPDF.php';

$datos = new ObtenerDatosCertificadoRadicar();
$cod_bpid = trim($_GET["value"]);
$datos->setDatos($cod_bpid);

$pdf = new PDF('P', 'mm', 'A4'); // vertical, milimetros y tamaño
$pdf->SetMargins(20, 15, 40);
$cadena = 'Que el proyecto abajo referenciado , previo cumplimiento de los requisitos establecidos en el articulo,Que el proyecto abajo referenciado , previo cumplimiento de los requisitos establecidos en el articulo,se encuentra RADICADO en el Banco de Programas Y proyectos  de Inversion Publica del Departamento de Nariño-BPID, de acuerdo con la siguiente informacion';
$cadena = utf8_decode($cadena);
//$pdf->Open();
$pdf->AddPage();
$pdf->Ln(15);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(170, 6, 'FICHA DE RADICACION', 0, 0, 'C');
$pdf->Ln(10);
$pdf->SetFont('Arial', '', 11);
DisenoCertificacionesPDF::justificarParrafo($cadena, 1, $pdf);
$pdf->Ln(7);
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(60, 6, utf8_decode('Codigo Radicacion'), 0, 0);
$pdf->Cell(68, 6, utf8_decode('Fecha Radicacion'), 0, 0);
$pdf->Cell(78, 6, utf8_decode('Hora Radicacion'), 0, 0);
$pdf->Ln(5);
$pdf->SetFont('Arial', '', 11);
$pdf->Cell(60, 6, utf8_decode($datos->getCodigoRadicacion()), 0, 0);
$pdf->Cell(68, 6, utf8_decode($datos->getFechaRadicacion()), 0, 0);
$pdf->Cell(78, 6, utf8_decode($datos->getHoraRadicacion()), 0, 0);
$pdf->Ln(7);
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(60, 6, utf8_decode('Nombre Programa o Proyecto:'), 0, 0);
$pdf->Ln(7);
$pdf->SetFont('Arial', '', 11);
DisenoCertificacionesPDF::justificarParrafo(utf8_decode($datos->getNomProyecto()), 1, $pdf);
$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(60, 6, utf8_decode('Numero Proyecto MGA Web:'), 0, 0);
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(60, 6, utf8_decode($datos->getNumproyecto()), 0, 0);
$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(60, 6, utf8_decode('Sector de Inversion:'), 0, 0);
$pdf->SetFont('Arial', '', 11);
$pdf->Cell(60, 6, utf8_decode($datos->getSectorProyecto()), 0, 0);
$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(60, 6, utf8_decode('Localizacion Especifica:'), 0, 0);
$pdf->SetFont('Arial', '', 11);
$pdf->Cell(60, 6, utf8_decode($datos->getLocProyecto()), 0, 0);
$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(60, 6, utf8_decode('Entidad Proponente:'), 0, 0);
$pdf->SetFont('Arial', '', 11);
$pdf->Cell(60, 6, utf8_decode($datos->getentp()), 0, 0);
$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(60, 6, utf8_decode('Entidad Ejecutora:'), 0, 0);
$pdf->SetFont('Arial', '', 11);
$pdf->Cell(60, 6, utf8_decode($datos->geteneje()), 0, 0);
$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(60, 6, utf8_decode('Responsable Proyecto:'), 0, 0);
$pdf->SetFont('Arial', '', 11);
$pdf->Cell(68, 6, utf8_decode($datos->getresponsable()), 0, 0);
$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(60, 6, utf8_decode('Numero Identificacion:'), 0, 0);
$pdf->SetFont('Arial', '', 11);
$pdf->Cell(60, 6, utf8_decode($datos->getidResponsable()), 0, 0);
$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(60, 6, utf8_decode('Direccion:'), 0, 0);
$pdf->SetFont('Arial', '', 11);
$pdf->Cell(60, 6, utf8_decode($datos->getdireccion()), 0, 0);
$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(60, 6, utf8_decode('Telefono'), 0, 0);
$pdf->Cell(68, 6, utf8_decode('Fax'), 0, 0);
$pdf->Cell(78, 6, utf8_decode('Celular'), 0, 0);
$pdf->Ln(5);
$pdf->SetFont('Arial', '', 11);
$pdf->Cell(60, 6, utf8_decode($datos->gettelefono()), 0, 0);
$pdf->Cell(68, 6, utf8_decode($datos->gettelefono()), 0, 0);
$pdf->Cell(78, 6, utf8_decode($datos->getcelular()), 0, 0);
$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(60, 6, utf8_decode('Correo Electronico:'), 0, 0);
$pdf->SetFont('Arial', '', 11);
$pdf->Cell(68, 6, utf8_decode($datos->getcorreo()), 0, 0);
$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(60, 6, utf8_decode('Entrega Proyecto:'), 0, 0);
$pdf->SetFont('Arial', '', 11);
$pdf->Cell(68, 6, utf8_decode($datos->getnomusu()), 0, 0);
$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(60, 6, utf8_decode('Identificacion:'), 0, 0);
$pdf->SetFont('Arial', '', 11);
$pdf->Cell(68, 6, utf8_decode($datos->getidusu()), 0, 0);
$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(60, 6, utf8_decode('Observaciones:'), 0, 0);
$pdf->Ln(7);
$pdf->SetFont('Arial', '', 11);
DisenoCertificacionesPDF::justificarParrafo(utf8_decode($datos->getobservaciones()), 1, $pdf);

$pdf->Ln(7);
$pdf->Cell(90, 6, '__________________________________', 0, 0);
$pdf->Cell(90, 6, '__________________________________', 0, 0);
$pdf->Ln(5);
$pdf->Cell(90, 6, $datos->getUsuario(), 0, 0, 'C');
$pdf->Cell(90, 6, $datos->getresponsable(), 0, 0, 'C');
$pdf->Ln(5);
$pdf->Cell(90, 6, 'Funcionario Responsable Radicacion', 0, 0, 'C');
$pdf->Cell(90, 6, 'Responsable Programa o Proyecto', 0, 0, 'C');


$pdf->Output();
?>

