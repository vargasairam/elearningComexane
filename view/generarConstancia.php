<?php
error_reporting(E_ERROR | E_PARSE); // solo errores graves
ini_set('display_errors', '0');

include '../config/config.php';
if (!isset($_SESSION[AMBIENTE]['usuario'])) {
    header("Location: ./signin.php");
    exit;
}

require '../core/conexion.php';
require '../model/alumno.php';

$A = new Alumno();
$alumno = $A->load($_SESSION[AMBIENTE]['usuario']['id'], $_SESSION[AMBIENTE]['usuario']['rol']);

use setasign\Fpdi;

require_once '../vendor/autoload.php';

class Pdf extends Fpdi\Tcpdf\Fpdi
{
    protected $tplId;
}

$fondo = '../constancias/Constancia Asistentes Curso AMEH 2023.pdf';
if (isset($_GET['ttr'])) {
    $fondo = "../constancias/2026/MODULO " . base64_decode($_GET['ttr']) . ".pdf";
}

ob_start();
$pdf = new Pdf('L', 'cm', array(27.94, 15.72));
$pdf->AddPage();
$pdf->SetLeftMargin(0);
$pdf->SetTopMargin(0);
$pdf->SetRightMargin(0);
$pdf->SetAutoPageBreak(0, 0);
$pdf->setSourceFile($fondo);
$tplidx = $pdf->ImportPage(1);
$pdf->useTemplate($tplidx, null, null, 27.94, 15.72, FALSE);
$pdf->SetFont("helvetica", 'B', 23);
$pdf->SetTextColor(0, 41, 96);
$pdf->SetXY(2, 10);
if (isset($_GET['ttr'])) {
    $pdf->SetXY(2, 5);
}
$pdf->MultiCell(24, .5, strtoupper($alumno->nombre) . " " . strtoupper($alumno->apellidos), 1, "C");
// $pdf->Output("Constancia_2025_" . $alumno->nombre . " " . $alumno->apellidos . ".pdf", "D");
// $pdf->Output($_SERVER['DO.""CUMENT_ROOT'] . 'output.pdf', '');
$pdf->Output("Constancia.pdf", "D");
ob_end_flush();
exit;
