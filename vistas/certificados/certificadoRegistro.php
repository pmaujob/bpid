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
require_once $raiz . '/modelo/MRegistrarResponsableEtapa.php';

$sess = new SessionVars();

$idRad = $_GET['idRad'];
$codBpid = $_GET['codBpid'];
        const etapa = 6;

$viabilidad = CargarViabilizados::getViabilizados($codBpid, 1)->fetch(PDO::FETCH_OBJ);
$viabilidadEjePro = MGetDatosCertificadoRegistro::getDatosProEjeSub($idRad)->fetch(PDO::FETCH_OBJ);
$actividades = MGetDatosCertificadoRegistro::getDatosFuentesFinanciazion($codBpid);
$nombre = MRegistrarResponsableEtapa::getResponsableEtapa($idRad, etapa)->fetch(PDO::FETCH_OBJ)->nombre;
$cargoSecretario = MGetDatosCertificadoRegistro::getSecretarios($idRad)->fetch(PDO::FETCH_OBJ)->cargo;

if (MGetDatosCertificadoRegistro::getSecretarios($idRad)->rowCount() > 0)
    $secretario = MGetDatosCertificadoRegistro::getSecretarios($idRad)->fetch(PDO::FETCH_OBJ)->nom;
else
    $secretario = '';

$informacion = utf8_encode('El programa o proyecto denominado ') . utf8_decode($viabilidad->nompro)
        . utf8_decode(' se encuentra registrado con código BPIN ') . $viabilidad->num
        . utf8_decode(', otorgado por el Banco de Programas y Proyectos de inversión Pública del Departamento de nariño.');

$informacion2 = utf8_decode('Cuenta con concepto de vibilidad técnica favorable expedida por ' . $sess->getValue('secretaria')) . ' '
        . CambiarFormatos::cambiarFecha($viabilidad->fecvia) . utf8_decode(' y certificación de inclusión en Plan de Desarrollo Departamental.');

$informacion3 = 'El proyecto se encuentra incluido en el Plan de Desarrollo Departamental 2012 - 2017, ' . utf8_decode('Eje estratégico: ')
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

$pdf->Cell(44, 4, "Tipo de Recursos", 1, 0, 'C', true);
$pdf->Cell(44, 4, "Valor", 1, 0, 'C', true);
//$pdf->Cell(35, 4, "Periodo", 1, 0, 'C', true);
$pdf->Cell(44, 4, "Tipo Entidad", 1, 0, 'C', true);
$pdf->Cell(44, 4, "Nombre Entidad", 1, 0, 'C', true);
$pdf->SetFillColor(255, 255, 255);
$pdf->SetTextColor(0);
$pdf->Ln();

foreach ($actividades as $row) {

    $rowLines = $pdf->getNumberLn(44, 4, utf8_decode($row[0]));
    $rowLines2 = $pdf->getNumberLn(44, 4, utf8_decode($row[2]));
    $rowLines3 = $pdf->getNumberLn(44, 4, utf8_decode($row[3]));

    $aux = [$rowLines, $rowLines2, $rowLines3];
    $mayor = $aux[0];

    for ($i = 1; $i < 3; $i++) {
        if ($aux[$i] > $mayor)
            $mayor = $aux[$i];
    }

    $mayor *= 4;

    DisenoCertificacionesPDF::justificarParrafo(utf8_decode($row[0]), 3.868, $pdf, 1, $mayor / $rowLines);
    $pdf->backLn(64, $mayor);
    $pdf->Cell(44, $mayor, utf8_decode($row[1]), 1, 0, 'C');
    DisenoCertificacionesPDF::justificarParrafo(utf8_decode($row[2]), 3.868, $pdf, 1, $mayor / $rowLines2);
    $pdf->backLn(152, $mayor);
    DisenoCertificacionesPDF::justificarParrafo(utf8_decode($row[3]), 3.868, $pdf, 1, $mayor / $rowLines3);
    
}

$pdf->Ln(20);
$pdf->Cell(106, 6, "_________________________________________", 0, 0);
$pdf->Cell(0, 6, "___________________________________________", 0, 0);
$pdf->Ln();
$pdf->SetFont('Arial', '', 11);
$pdf->Cell(106, 6, $secretario, 0, 0);
$pdf->Cell(0, 6, $nombre, 0, 0);
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(106, 6, $cargoSecretario, 0, 0);
$pdf->Cell(0, 6, "Funcionario Responsable", 0, 0);

$pdf->Output();
?>