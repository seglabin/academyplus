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

//$corps=$_SESSION["corps"];
//corps du document
//" " . "," . $client . "," . $datevente . "," . $remise . "," . $numfacture . "," . $total . "," . $titlef.  "," . $tva. "," . $ht
$donnee = $_SESSION["corps"]; // // Contenu date location facture client caution avec le titre
$e = explode(",", $donnee);

$corps = 'CLIENT : '.$e[1]; // entete du tableau
$datelocation = $e[2];
$remise = $e[3]; 
$numfacture = $e[4]; 
$total = $e[5]; 
$titlef = $e[6]; 
$tva = $e[7]; 
$ht = $e[8]; 
$enlettr = $e[9]; 
$montpaye = $e[10]; 
$rest = $e[11]; 
$header = $_SESSION["header"]; // entete du tableau
$headerBD = $_SESSION["headerBD"]; // parametre du tableau (les colonnes) dans $_SESSION["requete"]
$tabAlign = $_SESSION["tabAlign"];
$width = $_SESSION["width"]; // taille de chaque colonne (Leur somme doit donner 190) 
$data = $_SESSION["requete"]; // Contenu du tableau
//ENtete
// D�calage � droite
  $pdf->Cell(-123);
$pdf->MultiCell(0, 40, utf8_decode($titlef), 0, 'C', $fill);
$pdf->SetFont('Arial', '', 12);
//$pdf->Image('../images/barnierea.jpg', 15, 15, 50, 20);
//$pdf->MultiCell(0, 15, utf8_decode($corps), 0, 'J', $fill);


// Affichage de la facture ou pro format

// D�calage � droite
  $pdf->Cell(130);
$pdf->MultiCell(0, 5, utf8_decode('DATE : '.$datelocation), 0, 'J', $fill);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(130);
$pdf->MultiCell(0, 5, utf8_decode('FACTURE N° : '.$numfacture), 0, 'J', $fill);
$pdf->SetFont('Arial', 'BI', 12);
$pdf->MultiCell(0, 5, utf8_decode($corps), 0, 'J', $fill);


// Affichage du tableau
//$pdf->MultiCell(0, 5, utf8_decode(''), $border, 'L', $fill);

$pdf->FancyTable($header, $headerBD, $data, $width, $_SESSION["borduretableau"],$tabAlign);

$pdf->MultiCell(0, 10, utf8_decode('TOTAL HT : '.$ht), 0, 'R', $fill);
$pdf->MultiCell(0, 10, utf8_decode('Remise : '.$remise), 0, 'R', $fill);
$pdf->MultiCell(0, 10, utf8_decode('TVA : '.$tva), 0, 'R', $fill);

$pdf->SetFont('Arial', 'BI', 12);
$pdf->MultiCell(0, 10, utf8_decode('TOTAL TTC : '.$total), 0, 'R', TRUE);
$pdf->MultiCell(0, 10, utf8_decode('Montant payé : '.$montpaye), 0, 'R', TRUE);
$pdf->MultiCell(0, 10, utf8_decode('Reste à payer : '.$rest), 0, 'R', TRUE);
$pdf->MultiCell(0, 10, utf8_decode('Arrêté à la somme de '.$enlettr.' FCFA TTC'), 0, 'L', TRUE);
$pdf->MultiCell(0, 15, utf8_decode(''), $border, 'L', $fill);
$pdf->Cell(70);
//$pdf->MultiCell(0, 2, utf8_decode('MENTION : CARBURATION NON PRISE EN CHARGE '), $border, 'L', $fill);

//Bas du document
$tabbas = $_SESSION["basdoc"];
if (sizeof($tab, 1) > 0) {
    foreach ($tabbas as $v) {
        $pdf->ln(1);
        $pdf->SetFont('Arial', 'U', 12);
        $pdf->MultiCell(0, 5, utf8_decode($v), $border, 'R', $fill);
    }
}

$dat = new DateTime();
$gama = $_SESSION["nomfichier"]."_".$dat->format("d-m-Y-H-i-s");
$pdf->Output(utf8_decode($gama), "I");

