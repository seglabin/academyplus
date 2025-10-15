<?php

if (!isset($_SESSION)) {
session_start();
}
error_reporting(0);
include_once("../config/connect.php"); //inclusion du fichier de configuration de connection
require('fpdf/fpdf.php');
include('Class_impression.php');
include('../class/Functions.php');

// Instanciation de la classe dérivée
$pdf = new PDF($_SESSION["orientationpage"], 'mm', 'A4');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 14);
/*
 * Impression du corps du Document
 */
//MultiCell($w, $h, $txt, $border=0, $align='J', $fill=false)
// Affichage du titre
$fill = FALSE;
$border = 0;
//$pdf->MultiCell(0, 10, utf8_decode($_SESSION["titre"]), $border, 'C', $fill);
//$pdf->ln(2);


//Haut du document
$tab = $_SESSION["hautdoc"];
if (sizeof($tab, 1) > 0) {
    foreach ($tab as $v) {
        $pdf->ln(1);
        $pdf->SetFont('Arial', '', 12);
        $pdf->MultiCell(0, 20, utf8_decode($v), $border, 'L', $fill);
    }
}

$corps=$_SESSION["corps"];//corps du document

$pdf->MultiCell(0, 10, utf8_decode('ATTESTATION DE SERVICE FAIT'), 0, 'C', $fill);
$pdf->SetFont('Arial', '', 12);
$pdf->MultiCell(0, 15, utf8_decode($corps), 0, 'J', $fill);

//Bas du document
$tab = $_SESSION["basdoc"];
if (sizeof($tab, 1) > 0) {
    foreach ($tab as $v) {
        $pdf->ln(1);
        $pdf->SetFont('Arial', 'U', 12);
        $pdf->MultiCell(0, 5, utf8_decode($v), $border, 'R', $fill);
    }
}

$dat = new DateTime();
$gama = $_SESSION["nomfichier"]."_".$dat->format("d-m-Y-H-i-s");
$pdf->Output(utf8_decode($gama), "I");

?>