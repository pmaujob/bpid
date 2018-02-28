<?php

date_default_timezone_set('America/Bogota');
session_start();

if (!isset($_SESSION['idRad']) && isset($_POST['idRad'])) {
    $_SESSION['idRad'] = $_POST['idRad'];
} else if (!isset($_SESSION['idRad']) && !isset($_POST['idRad'])) {
    return;
}
$raiz = $_SESSION['raiz'];
$raizHtml = $_SESSION['raizHtml'];

require_once $raiz . '/librerias/fpdf/fpdf.php';
require_once $raiz . '/librerias/fpdf/PDF.php';
require_once $raiz . '/librerias/DisenoCertificacionesPDF.php';
require_once $raiz . '/modelo/CargarDatosCerViabilidad.php';
require_once $raiz . '/modelo/CargarDatosCerViabilidad.php';
require_once $raiz . '/librerias/CambiarFormatos.php';
require_once $raiz . '/librerias/SessionVars.php';

$sess = new SessionVars();

$datosRadicacion = CargarDatosCerViabilidad::getDatosInformeNoViabilidad($_SESSION['idRad']);

$pdf = new FPDF('P', 'mm', 'Letter'); // vertical, milimetros y tamaño
$pdf->SetMargins(20, 15, 20);
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 8);

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
$pdf->Cell(10, 6, utf8_decode('Código Formato: BPID-CNV01'));
$pdf->Ln(0);
$pdf->Cell(0, 6, utf8_decode('Versión: 02'), 0, 0, 'C');
$pdf->Ln(0);
$pdf->Cell(0, 6, utf8_decode('Fecha Formato: ' . date("d/M/Y")), 0, 0, 'R');
$pdf->Ln(10);

foreach ($datosRadicacion as $row) {

    $observaciones = CargarDatosCerViabilidad::getObservaciones($_SESSION['idRad'])->fetchAll(PDO::FETCH_BOTH);

    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(0, 6, utf8_decode('CERTIFICADO DE NO VIABILIDAD'), 0, 0, 'C');
    $pdf->Ln(10);
    DisenoCertificacionesPDF::justificarParrafo(utf8_decode("El programa o proyecto denominado " . $row[1] . ", radicado el día " . CambiarFormatos::cambiarFecha($row[2]) . ", identificado con código de radicación: " . $row[3] . "."), 0.965, $pdf);
    $pdf->Ln(5);
    $pdf->Cell(0, 4, utf8_decode('Cuenta con viabilidad DESFAVORABLE por ' . (count($observaciones) > 1 ? 'las siguientes observaciones:' : 'la siguiente observación:')));
    $pdf->Ln(10);

    for ($i = 0; $i < count($observaciones); $i++) {
        $o = $observaciones[$i];

        $pdf->Cell(0, 6, utf8_decode('* ' . $o[3] . ':'));
        $pdf->Ln();
        DisenoCertificacionesPDF::justificarParrafo(utf8_decode($o[1]), 0.965, $pdf);
        $pdf->Ln(5);
    }

    $pdf->Ln(10);
    $pdf->Cell(0, 4, utf8_decode('Se expide en San Juan de Pasto, ' . CambiarFormatos::cambiarFecha(date("d-M-Y")) . '.'));
    $pdf->SetMargins(30, 15, 30);
    $pdf->Ln(20);

    $responsables = CargarDatosCerViabilidad::getResponsables($_SESSION['idRad'])->fetchAll(PDO::FETCH_BOTH);
    for ($i = 0; $i < count($responsables); $i += 2) {
        $r = $responsables[$i];

        $pdf->Cell(0, 6, utf8_decode('________________________________________'));
        $pdf->Ln(4);
        $pdf->Cell(0, 6, utf8_decode($r[1] . " " . $r[2]));
        $pdf->Ln(4);
        $pdf->Cell(0, 6, utf8_decode($r[3]));
        $pdf->Ln();

        if (isset($responsables[$i + 1])) {

            $r2 = $responsables[$i + 1];

            $pdf->backLn(0, 15);
            $pdf->Cell(0, 6, utf8_decode('________________________________________'), 0, 0, 'R');
            $pdf->Ln(4);
            $pdf->Cell(0, 6, utf8_decode($r2[1] . " " . $r2[2]), 0, 0, 'R');
            $pdf->Ln(4);
            $pdf->Cell(0, 6, utf8_decode($r2[3]), 0, 0, 'R');
            $pdf->Ln();
        }
        $pdf->Ln(15);
    }

    $pos = (count($responsables) % 2 == 0 ? 'L' : 'R');
    if ($pos == 'R') {
        $pdf->backLn(0, 29);
    }
    $pdf->Cell(0, 6, utf8_decode('________________________________________'), 0, 0, $pos);
    $pdf->Ln(4);
    $pdf->Cell(0, 6, utf8_decode($sess->getValue('usuario')), 0, 0, $pos);
    $pdf->Ln(4);
    $pdf->Cell(0, 6, utf8_decode("Funcionario Responsable"), 0, 0, $pos);
    $pdf->Ln();

    break;
}
$pdf->Output();
?>
