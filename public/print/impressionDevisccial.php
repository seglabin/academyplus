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
//$pdf->SetFont('Arial', 'B', 14);
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
    $i = 0;
    foreach ($tab as $v) {
        $pdf->ln(1);
        $pdf->SetFont('Arial', 'B', 8);
        if ($i == 0) {
            $pdf->MultiCell(0, 5, utf8_decode($v), $border, 'R', $fill);
        } else {
            $pdf->MultiCell(0, 5, utf8_decode($v), $border, 'L', $fill);
        }
        $i++;
    }
}


$header = $_SESSION["header"]; // entete du tableau
$headerBD = $_SESSION["headerBD"]; // parametre du tableau (les colonnes) dans $_SESSION["requete"]
$tabAlign = $_SESSION["tabAlign"];
$width = $_SESSION["width"]; // taille de chaque colonne (Leur somme doit donner 190) 
$data = $_SESSION["requete"]; // Contenu du tableau
//print_r($data);

//$j = 0;
//$ttc = $_SESSION["corps"];
foreach ($data as $v) {
//    if($j == 0 ) $ttc = $v['ttc'];
    $pdf->SetFont('Arial', 'UB', 12);
    $pdf->MultiCell(0, 10, utf8_decode($v['sousdevis']), 0, 'C', $fill);
    $pdf->SetFont('Arial', '', 10);
    if ($v['type'] == 0) {
        $pdf->FancyTable($header, $headerBD, $v['details'], $width, $_SESSION["borduretableau"], $tabAlign);
    } else {
        $listtitre = array("Désignation","Hauteur","Largeur", "Quantité", "Prix Unitaire", "Montant");
        $tabAlign1 = array("L", "R", "R", "R", "R", "R");
        $listcolonneBD = array("codeElt","hauteur","largeur", "quantite", "pvht", "montht");
        $listlargeurtitre = array(60,20,20, 20, 30, 40); //total 190
        $pdf->FancyTable($listtitre, $listcolonneBD, $v['details'], $listlargeurtitre, $_SESSION["borduretableau"], $tabAlign1);
    }
    $pdf->SetFont('Arial', 'UB', 12);
    $pdf->MultiCell(0, 10, utf8_decode($v['totalsousdevis']), 0, 'R', $fill);
//    $pdf->Ln(5);
}

list($ttc, $enlettre) = explode('|', $_SESSION["corps"]);
$pdf->SetFont('Arial', 'UB', 12);
$pdf->MultiCell(0, 10, utf8_decode('TOTAL : '.$ttc), 0, 'R', $fill);

$pdf->SetFont('Arial', 'I', 14);
$pdf->MultiCell(0, 8, utf8_decode('Nous estimons le coût global du présent devis à la somme de : '.$enlettre.' FRANCS CFA '), 0, 'L', TRUE);

//Bas du document
$tabbas = $_SESSION["basdoc"];
if (sizeof($tabbas, 1) > 0) {
        $listtitre = array("","");
        $tabAlign1 = array("L", "R");
        $listcolonneBD = array("col1","col2");
        $listlargeurtitre = array(95,95); //total 190
        $pdf->SetFont('Arial', '', 10);
        $pdf->FancyTable($listtitre, $listcolonneBD, $tabbas, $listlargeurtitre, 0, $tabAlign1);
       
}

$dat = new DateTime();
$gama = $_SESSION["nomfichier"] . "_" . $dat->format("d-m-Y-H-i-s");
$pdf->Output(utf8_decode($gama), "I");

// $_SESSION['avecpied'] = "";
//        $_SESSION['avecphoto'] = "";
