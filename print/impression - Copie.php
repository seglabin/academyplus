<?php
if (!isset($_SESSION)) {
    session_start();
}
error_reporting(0);
include_once("../config/connect.php"); //inclusion du fichier de configuration de connection
require('fpdf/fpdf.php');
include('Class_impression.php');
include_once('../class/Functions.php');

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

$pdf->ln(1);
$pdf->SetFont('Arial', 'B', 8);

$pdf->MultiCell(0, 5, utf8_decode(''), $border, 'L', $fill);
//Haut du document
$tab = $_SESSION["hautdoc"];
$th = $_SESSION['tailHaut'];
$hl = $_SESSION['hauteurligne'];
$pdf->SetFont('Arial', 'B', 12);
if (sizeof($tab, 1) > 0) {
    foreach ($tab as $v) {
        $pdf->ln(1);
        $pdf->SetFont('Arial', '', $th);
        $pdf->MultiCell(0,$hl, utf8_decode($v), $border, 'L', $fill);
    }
}
$pdf->SetFont('Arial', 'B', 8);
$header = $_SESSION["header"]; // entete du tableau
$headerBD = $_SESSION["headerBD"]; // parametre du tableau (les colonnes) dans $_SESSION["requete"]
$tabAlign = $_SESSION["tabAlign"];
$width = $_SESSION["width"]; // taille de chaque colonne (Leur somme doit donner 190) 
$data = $_SESSION["requete"]; // Contenu du tableau
// Affichage du tableau
$pdf->MultiCell(0, 2, utf8_decode(''), $border, 'L', $fill);
//print_r($header);
$pdf->FancyTable($header, $headerBD, $data, $width, $_SESSION["borduretableau"],$tabAlign);

$pdf->MultiCell(0, 2, utf8_decode(''), $border, 'L', $fill);
//Bas du document
$tab = $_SESSION["basdoc"];
if (sizeof($tab, 1) > 0) {
    foreach ($tab as $v) {
        $pdf->ln(1);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->MultiCell(0, 5, utf8_decode($v), $border, 'L', $fill);
    }
}
$dat = new DateTime();
$gama = $_SESSION["nomfichier"] . "_" . $dat->format("d-m-Y-H-i-s");
$pdf->Output(utf8_decode($gama), "I");
?>