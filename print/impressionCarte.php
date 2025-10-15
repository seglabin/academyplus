<?php

if (!isset($_SESSION)) {
    session_start();
}
error_reporting(0);
include_once("../config/connect.php"); //inclusion du fichier de configuration de connection
require('fpdf/fpdf.php');
include('./Class_impressionCarte.php');
include('../class/Functions.php');

// Instanciation de la classe dérivée
$pdf = new PDF($_SESSION["orientationpage"], 'mm', 'A4');
//$pdf->AliasNbPages();
$pdf->AddPage();
//$pdf->SetAutoPageBreak(true, 13);
//$pdf->SetFont('Arial', 'B', 10);
/*
 * Impression du corps du Document
 */


$fill = FALSE;
$border = 0;

//$n = 25;


$data = $_SESSION["requete"];
$n = sizeof($data, 0);
//libphoto|libetab|libannesco|nom|prenoms|datenaissance|lieunaissance|sexe|signataire
// $data[$i]['']
//Functions::afficheBoiteMsg($n);
for ($i = 1; $i <= $n; $i++) {
    if (($i % 2) == 1) {
        $y = $pdf->GetY() + 2;
        $pdf->SetY($y);

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->MultiCell(0, -5, "", 0, 'L', FALSE);
        $pdf->Cell(-5);
        $pdf->Cell(100, 68, utf8_decode(""), 1, 2, 'C');
        $pdf->MultiCell(0, -68, "", 0, 'L', FALSE);
//photo|etab|annesco|nom|prenoms|datenais|lieunais|sexe|signataire
//$pdf->Cell(-4);
                $pdf->Image('../traitement/images/Personnel/logoCarte.jpg', 6, $y - 5, 20, 17);
       
        $pdf->Cell(27);
        $pdf->MultiCell(0, 10, strtoupper(utf8_decode('republique du benin')), $border, 'L', $fill);
        $pdf->Cell(27);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->MultiCell(0, 0, (utf8_decode('Ministère des enseignements ')), $border, 'L', $fill);
        $pdf->Cell(20);
        $pdf->MultiCell(0, 10, (utf8_decode('Primaire secondaire et Professionnel')), $border, 'L', $fill);

        $yy = $pdf->GetY();
        $pdf->Image('../traitement/images/Personnel/drapeau.png', 0, ($yy -5), 110, 10);
        $pdf->ln(3);

        $y1 = $pdf->GetY();
        if (is_file($data[$i]['libphoto'])) {
            $pdf->Image($data[$i]['libphoto'], 78, $y1, 25, 27);
        } else {
            if ($data[$i]['idsexe'] == 2) {
                $pdf->Image('../traitement/images/Personnel/avatarHomme.jpg', 78, $y1, 25, 27);
            } else {
                $pdf->Image('../traitement/images/Personnel/avatarFemme.jpeg',78, $y1, 25, 27);
            }
        }

        $pdf->Cell(-3);
        $pdf->MultiCell(0, 5, strtoupper(utf8_decode($data[$i]['libetab'])), $border, 'L', $fill);
        $pdf->Cell(2);
        $pdf->MultiCell(0, 5, strtoupper(utf8_decode("Carte scolaire " . $data[$i]['libannesco'])), $border, 'L', $fill);
        $pdf->Cell(-3);
        $pdf->MultiCell(0, 5, (utf8_decode("Nom : " . $data[$i]['nom'])), $border, 'L', $fill);
        $pdf->Cell(-3);
        $pdf->MultiCell(0, 5, (utf8_decode("Prénoms : " . $data[$i]['prenoms'])), $border, 'L', $fill);
        $ln = 0;
        if ($data[$i]['datenaissance'] != '00-00-0000') {
            $pdf->Cell(-3); //00-00-0000
            $pdf->MultiCell(0, 5, (utf8_decode("Né(e) le : " . $data[$i]['datenaissance'] . '  à ' . $data[$i]['lieunaissance'])), $border, 'L', $fill);
        } else {
            $ln += 5;
//            $pdf->ln(5); laclas
        }
        $pdf->Cell(-3);
        $pdf->MultiCell(0, 5, (utf8_decode("Classe : " . $data[$i]['laclas']."      Sexe : " . $data[$i]['sexe'])), $border, 'L', $fill);
        $pdf->ln(2);
        $pdf->Cell(27);
        $pdf->MultiCell(0, 5, (utf8_decode("Le Directeur ")), $border, 'L', $fill);
        $pdf->Cell(2);
        $pdf->MultiCell(0, 7, (utf8_decode('Germain Maxime ATTOLOU')), $border, 'L', $fill);
        $pdf->ln(5 + $ln);
    } else {

        $pdf->SetFont('Arial', 'B', 12);

        $pdf->SetY($y - 5);
        $pdf->setX(107);
        $pdf->Cell(100, 68, utf8_decode(""), 1, 2, 'C');
        $pdf->MultiCell(0, -68, "", 0, 'L', FALSE);
        $pdf->Image('../traitement/images/Personnel/logoCarte.jpg', 108, ($y - 5), 20, 17);
       
        $pdf->Cell(27 + 98);
        $pdf->MultiCell(0, 10, strtoupper(utf8_decode('republique du benin')), $border, 'L', $fill);
        $pdf->Cell(27 + 98);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->MultiCell(0, 0, (utf8_decode('Ministère des enseignements ')), $border, 'L', $fill);
        $pdf->Cell(20 + 98);
        $pdf->MultiCell(0, 10, (utf8_decode('Primaire secondaire et Professionnel')), $border, 'L', $fill);
        $yy = $pdf->GetY();
        $pdf->Image('../traitement/images/Personnel/drapeau.png', (102), ($yy -5), 110, 10);
        $pdf->ln(2);
        $y2 = $pdf->GetY();
         if (is_file($data[$i]['libphoto'])) {
            $pdf->Image($data[$i]['libphoto'], 180, ($y2 + 1), 25, 27);
        } else {
            if ($data[$i]['idsexe'] == 2) {
                $pdf->Image('../traitement/images/Personnel/avatarHomme.jpg', 180, ($y2 + 1), 25, 27);
            } else {
                $pdf->Image('../traitement/images/Personnel/avatarFemme.jpeg', 180, ($y2 + 1),25, 27);
            }
        }
        
        $pdf->ln(2);
        $pdf->Cell(2 + 98);
        $pdf->MultiCell(0, 5, strtoupper(utf8_decode($data[$i]['libetab'])), $border, 'L', $fill);
        $pdf->Cell(2 + 98);
        $pdf->MultiCell(0, 5, strtoupper(utf8_decode("Carte scolaire " . $data[$i]['libannesco'])), $border, 'L', $fill);
        $pdf->Cell(2 + 98);
        $pdf->MultiCell(0, 5, (utf8_decode("Nom : " . $data[$i]['nom'])), $border, 'L', $fill);
        $pdf->Cell(2 + 98);
        $pdf->MultiCell(0, 5, (utf8_decode("Prénoms : " . $data[$i]['prenoms'])), $border, 'L', $fill);
         $ln2 = 0;
        if ($data[$i]['datenaissance'] != '00-00-0000') {            
        $pdf->Cell(2 + 98);
        $pdf->MultiCell(0, 5, (utf8_decode("Né(e) le : " . $data[$i]['datenaissance'] . '  à ' . $data[$i]['lieunaissance'])), $border, 'L', $fill);
         } else {
              $ln2 += 5;
         }
        $pdf->Cell(2 + 98);
        $pdf->MultiCell(0, 5, (utf8_decode("Classe : " . $data[$i]['laclas']."      Sexe : " . $data[$i]['sexe'])), $border, 'L', $fill);
         $pdf->ln(2);
        $pdf->Cell(25 + 98);
        $pdf->MultiCell(0, 5, (utf8_decode("Le Directeur ")), $border, 'L', $fill);
        $pdf->Cell(2 + 98);
        $pdf->MultiCell(0, 7, (utf8_decode('Germain Maxime ATTOLOU')), $border, 'L', $fill);
        $pdf->ln(2 + $ln2);
    }
    if ($i % 8 == 0) {
        $pdf->AddPage();
    }
}


$pdf->Output("I");

