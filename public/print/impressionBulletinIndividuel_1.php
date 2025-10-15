<?php

if (!isset($_SESSION)) {
session_start();
}
error_reporting(0);
include_once("../config/connect.php"); //inclusion du fichier de configuration de connection
require('fpdf/fpdf.php');
include('Class_impressionBulletin.php');
include('../class/Functions.php');

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
//$pdf->ln(2);
//décalage 
 $pdf->Cell(-2);
$pdf->drawTextBox(utf8_decode(' '), 195, '48', 'C', 'T', 1);

//Haut du document
$tab = $_SESSION["hautdoc"];
if (sizeof($tab, 1) > 0) {
    foreach ($tab as $v) {
        $pdf->ln(1);
        $pdf->SetFont('Arial', '', 12);
        $pdf->MultiCell(0, 10, utf8_decode($v), $border, 'L', $fill);
    }
}

// $x = $this->GetX();
//            $y = $this->GetY();
            // Dessine le cadre et y imprime le texte centré horizontalement et verticalement
//            $this->drawTextBox(utf8_decode($header[$i]), $w[$i], $hentete, 'C', 'M', $border);

//$pdf->SetFillColor(150, 150, 100);
////        $pdf->SetTextColor(255);
//        $pdf->SetDrawColor(45, 45, 45);
//        $pdf->SetLineWidth(.1);
//        $pdf->SetFont('', 'B');
//        $pdf->Cell(-2);
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

$pdf->FancyTable($header, $headerBD, $data, $width, $_SESSION["borduretableau"],$tabAlign);

$pdf->MultiCell(0, 4, utf8_decode(''), $border, 'L', $fill);
 $pdf->drawTextBox(utf8_decode(' '), 195, '25', 'C', 'M', 1);
//Bas du document
$tabas = $_SESSION["basdoc"];
if (sizeof($tabas, 1) > 0) {    //Functions::afficheBoiteMsg(count($tabas));
    foreach ($tabas as $v) {        //Functions::afficheBoiteMsg($v);
        $pdf->ln(1);
        $pdf->SetFont('Arial', 'U', 12);
        $pdf->MultiCell(0, 5, utf8_decode($v), $border, 'R', $fill);
    }
}

$dat = new DateTime();
$gama = $_SESSION["nomfichier"]."_".$dat->format("d-m-Y-H-i-s");
$pdf->Output(utf8_decode($gama), "I");

