<?php

date_default_timezone_set('America/Bogota');
session_start();

$raiz = $_SESSION['raiz'];

require_once $raiz . '/librerias/fpdf/fpdf.php';
require_once $raiz . '/librerias/fpdf/PDF.php';
require_once $raiz . '/librerias/DisenoCertificacionesPDF.php';
require_once $raiz . '/modelo/CargarDatosCerViabilidad.php';

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
    $pdf->Ln(5);
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
    $pdf->Ln(5);
    $pdf->Cell(60, 6, utf8_decode('Cadena de Valor:'));
    $pdf->Ln(10);

    //========================== PRODUCTOS =========================================
    $productos = CargarDatosCerViabilidad::getProductos($row[13]);
    foreach ($productos as $p) {

        $pdf->SetFillColor(0, 134, 67);
        $pdf->SetTextColor(255);
        $pdf->Cell(176, 8, 'Producto', 1, 0, 'C', true);
        $pdf->Ln();

        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetTextColor(0);
        $pdf->Cell(90, 8, utf8_decode('Descripción'), 1, 0, 'C');
        $pdf->Cell(43, 8, 'Cantidad', 1, 0, 'C');
        $pdf->Cell(43, 8, 'Costo', 1, 0, 'C');
        $pdf->Ln();

        $productDes = utf8_decode($p[1]);
        $aProductLines = $pdf->getNumberLn(90, 4, $productDes);

        DisenoCertificacionesPDF::justificarParrafo($productDes, 1.89, $pdf, 1, 6);
        $pdf->backLn(110, $aProductLines * 6);
        $pdf->Cell(43, $aProductLines * 6, $p[2], 1);
        $pdf->Cell(43, $aProductLines * 6, '$' . '1000000000000', 1);
        $pdf->Ln();

        $pdf->SetFillColor(187, 208, 73);
        $pdf->SetTextColor(255);
        $pdf->Cell(176, 8, 'Actividades', 1, 0, 'C', true);
        $pdf->Ln();

        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetTextColor(0);
        $pdf->Cell(11, 8, utf8_decode('No.'), 1, 0, 'C');
        $pdf->Cell(65, 8, utf8_decode('Descripción'), 1, 0, 'C');
        $pdf->Cell(35, 8, 'Valor', 1, 0, 'C');
        $pdf->Cell(65, 8, 'Meta', 1, 0, 'C');
        $pdf->Ln();

        $i = 1;
        $actividades = CargarDatosCerViabilidad::getActividades($p[0]);
        foreach ($actividades as $a) {

            $textDes = utf8_decode(ucfirst($a[2]));
            $textMeta = utf8_decode(ucfirst($a[5] . " - " . $a[4]));

            $aNameLines = $pdf->getNumberLn(65, 4, $textDes);
            $aMetaLines = $pdf->getNumberLn(65, 4, $textMeta);
            $aMost = ($aNameLines > $aMetaLines ? $aNameLines : $aMetaLines) * 4;

            $pdf->Cell(11, $aMost, $i, 1);
            DisenoCertificacionesPDF::justificarParrafo($textDes, 2.615, $pdf, 1, $aMost / $aNameLines);
            $pdf->backLn(96, $aMost);
            $pdf->Cell(35, $aMost, "$" . $a[1], 1);
            DisenoCertificacionesPDF::justificarParrafo($textMeta, 2.615, $pdf, 1, $aMost / $aMetaLines);

            $i++;
        }
        $pdf->Ln(5);
    }

    $pdf->Ln(5);
    $pdf->Cell(60, 6, utf8_decode('Descripción del programa o proyecto:'));
    $pdf->Ln(5);
    DisenoCertificacionesPDF::justificarParrafo(utf8_decode(ucfirst($row[10])), 0.965, $pdf); //*************
    $pdf->Ln(5);
    $pdf->Cell(60, 6, utf8_decode('Número estimado de beneficiarios (Población): ' . $row[11]));
    $pdf->Ln(10);
    $pdf->Cell(60, 6, utf8_decode('Localización: ' . $row[12]));

    break;
}
$pdf->Output();
?>
