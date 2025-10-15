<?php

if (!isset($_SESSION)) {
    session_start();
}
error_reporting(0);
include_once("../config/connect.php"); //inclusion du fichier de configuration de connection
require('fpdf/fpdf.php');
include('Class_impressionBulletin.php');
include('../class/Functions.php');
//for ($i = 0; $i < 2; $i++) {
// Instanciation de la classe dérivée
$pdf = new PDF($_SESSION["orientationpage"], 'mm', $_SESSION["size"]);
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
$pdf->ln(5);
//décalage 
$pdf->Cell(-2);
$pdf->drawTextBox(utf8_decode('.'), 195, 245, 'C', 'T', TRUE);
//Haut du document
$tab = $_SESSION["hautdoc"];
if (sizeof($tab, 1) > 0) {
    foreach ($tab as $v) {
        $pdf->ln(1);
        $pdf->SetFont('Arial', '', 12);
        $pdf->MultiCell(0, 10, utf8_decode($v), $border, 'L', $fill);
    }
}

$pdf->Cell(-2);
//            $pdf->drawTextBox(utf8_decode(' '), 195, '80', 'C', 'M', 1);
//                
//Repositionne à droite
//            $this->SetXY($x + $w[$i], $y);
//            $this->Cell($w[$i], 7, utf8_decode($header[$i]), 1, 0, 'C', true);
//$corps=$_SESSION["corps"];
//corps du document
// $corps = $laclas . "," . $etab . "," . $an . "," . $appr . "," . $dateinscri . "," . $ref . "," . $totp . "," . $montlettre . ',' . $reste; 

$donnee = $_SESSION["corps"]; // // Contenu date location facture client caution avec le titre
$e = explode(",", $donnee);

//$corps = 'Etablissement : '.$e[1]; // entete du tableau
//$etab = 'Etablissement : '.$e[1]; // entete du tableau
//$an = $e[2];
//$clas = $e[0];
//$date = $e[4];
//
//$apprenant = $e[3]; 
//$numfacture = $e[5]; 
//$total = $e[6]; 
//$enlettr = $e[7]; 
//$totpai = $e[8]; 
//$rest = $e[9]; 


$header = $_SESSION["header"]; // entete du tableau
$headerBD = $_SESSION["headerBD"]; // parametre du tableau (les colonnes) dans $_SESSION["requete"]
$tabAlign = $_SESSION["tabAlign"];
$width = $_SESSION["width"]; // taille de chaque colonne (Leur somme doit donner 190) 
$data = $_SESSION["requete"]; // Contenu du tableau
// Affichage du tableau
$pdf->MultiCell(0, 2, utf8_decode(''), $border, 'L', $fill);
$pdf->SetFont('Arial', '', 10);
$pdf->FancyTable($header, $headerBD, $data, $width, $_SESSION["borduretableau"], $tabAlign);

$pdf->MultiCell(0, 5, utf8_decode(''), $border, 'R', $fill);

$tabbas = $_SESSION["basdoc"];
if (sizeof($tabbas, 1) > 0) {
    $tb1 = $tabbas[0];
    $tb2 = $tabbas[1];
    $listtitre = array('Tot. Coef.', 'Tot. Moy.', 'Moyenne', 'Rang', 'Plus forte Moy.', 'Plus faible Moy', 'Moy. de la classe');
//        $listtitre = array();
    $tabAlign1 = array("C", "C", "C", "C", "C", "C", "C");
    $listcolonneBD = array("col1", "col2", "col3", "col4", "col5", "col6", "col7");
    $listlargeurtitre = array(20, 20, 20, 20, 36, 37, 37); //total 190
    $pdf->SetFont('Arial', '', 10);
//        $pdf->SetXY($x + $w[$i], $y);
//        $pdf->SetXY(200, 22);
    $n = count($data);  //  Functions::afficheBoiteMsg($n);
    $pdf->FancyTable($listtitre, $listcolonneBD, $tb1, $listlargeurtitre, 1, $tabAlign1);
    $pdf->MultiCell(0, 5, utf8_decode(''), $border, 'L', $fill);

     $pdf->SetFont('Arial', 'B', 12);
    $pdf->MultiCell(0, 10, utf8_decode('Appréciation du Directeur '), $border, 'C', $fill);
    $pdf->MultiCell(0, 10, utf8_decode($tb2[0]['col2']), $border, 'C', $fill);
     $pdf->SetFont('Arial', 'BU', 13);
//    $pdf->ln(3);
    $pdf->MultiCell(0, 10, utf8_decode('Signature'), $border, 'C', $fill);
     $pdf->SetFont('Arial', 'B', 13);
    $pdf->MultiCell(0, 10, utf8_decode('Le Professeur Principal                                                     Le Directeur                   '), $border, 'C', $fill);
    $pdf->ln(15);
    
   
    $pdf->MultiCell(0, 10, utf8_decode($tb2[0]['col3'].'          '), $border, 'R', $fill);
    
}
//$a = ((16 - $n) * 10) + 5;
//$pdf->ln($a);

$dat = new DateTime();
$gama = $_SESSION["nomfichier"] . "_" . $dat->format("d-m-Y-H-i-s");
$pdf->Output(utf8_decode($gama), "I");
//}

