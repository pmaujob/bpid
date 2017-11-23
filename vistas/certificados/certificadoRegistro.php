<?php

date_default_timezone_set('America/Bogota');
@session_start();

$raiz = $_SESSION['raiz'];
$raizHtml = $_SESSION['raizHtml'];

require_once $raiz . '/librerias/fpdf/fpdf.php';
require_once $raiz . '/librerias/fpdf/PDF.php';
require_once $raiz . '/librerias/DisenoCertificacionesPDF.php';
require_once $raiz . '/modelo/MGetDatosCertificadoRegistro.php';
require_once $raiz . '/modelo/CargarViabilizados.php';
require_once $raiz . '/librerias/CambiarFormatos.php';
require_once $raiz . '/librerias/SessionVars.php';

$sess = new SessionVars();

$idRad = $_GET['idRad'];
$codBpid = $_GET['codBpid'];

$viabilidad = CargarViabilizados::getViabilizados($codBpid, 1)->fetch(PDO::FETCH_OBJ);
$viabilidadEjePro = MGetDatosCertificadoRegistro::getDatosProEjeSub($idRad)->fetch(PDO::FETCH_OBJ);
$actividades = MGetDatosCertificadoRegistro::getDatosFuentesFinanciazion($codBpid);

$informacion = utf8_encode('El programa o proyecto denominado ') . utf8_decode($viabilidad->nompro)
        . utf8_decode(' se encuentra registrado con código BPI ') . $viabilidad->num
        . utf8_decode(', otorgado por el Banco de Programas y Proyectos de inversión Pública del Departamento de nariño.');

$informacion2 = utf8_decode('Cuenta con concepto de vibilidad técnica favorable expedida por ' . $sess->getValue('secretaria')) . ' '
        . CambiarFormatos::cambiarFecha($viabilidad->fecvia) . utf8_decode(' y certificación de inclusión en Plan de Desarrollo Departamental.');

$informacion3 = 'El proyecto se encuentra incluido en el Plan de Desarrollo Departamental 2012 - 2017, ' .utf8_decode('Eje estratégico: ')
        . utf8_decode($viabilidadEjePro->eje) . ' Programa: ' . utf8_decode($viabilidadEjePro->pro) . ', Subprograma: ' . utf8_decode($viabilidadEjePro->sub);

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

$pdf->Cell(0, 6, utf8_encode('CERTIFICADO DE REGISTRO'), 0, 0, 'C');
$pdf->Ln(6);
$pdf->MultiCell(0, 4, $informacion);
$pdf->Ln(4);
$pdf->MultiCell(0, 4, $informacion2);
$pdf->Ln(4);
$pdf->MultiCell(0, 4, $informacion3);
$pdf->Ln(4);
$pdf->Cell(0, 6, utf8_encode('El proyecto cuenta con la siguiente solicitud de recurso: '), 0, 0, 'C');
$pdf->Ln(10);
//0,4

$pdf->SetFillColor(0, 134, 67);
$pdf->SetTextColor(255);
$pdf->Cell(176, 6, "ACTIVIDADES", 1, 0, 'C', true);
$pdf->Ln();

$pdf->Cell(35, 4, "Tipo de Recursos", 1, 0, 'C', true);
$pdf->Cell(35, 4, "Valor", 1, 0, 'C', true);
$pdf->Cell(35, 4, "Periodo", 1, 0, 'C', true);
$pdf->Cell(36, 4, "Tipo Entidad", 1, 0, 'C', true);
$pdf->Cell(35, 4, "Nombre Entidad", 1, 0, 'C', true);
$pdf->SetFillColor(255, 255, 255);
$pdf->SetTextColor(0);
$pdf->Ln();

foreach ($actividades as $row) {

    $lnsOrigen = $pdf->getNumberLn(35, 4, utf8_decode($row[0]));
    DisenoCertificacionesPDF::justificarParrafo(utf8_decode($row[0]), 4.855, $pdf, 1); //c1    
    $pdf->backLn(55, $lnsOrigen * 4);
    $pdf->Cell(35, $lnsOrigen * 4, utf8_decode($row[1]), 1, 0, 'C');
    $pdf->Cell(35, $lnsOrigen * 4, utf8_decode($row[2]), 1, 0, 'C');
    $pdf->Cell(36, $lnsOrigen * 4, utf8_decode($row[3]), 1, 0, 'C');
    $pdf->Cell(35, $lnsOrigen * 4, utf8_decode($row[4]), 1, 0, 'C');
    $pdf->Ln();
}

$pdf->Output();
?>