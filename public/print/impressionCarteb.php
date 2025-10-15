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

$d1 = 'ZAZAZ';
$d2 = 'ZEZE';
$data = $_SESSION["requete"];
$n = sizeof($data,0);
//libphoto|libetab|libannesco|nom|prenoms|datenaissance|lieunaissance|sexe|signataire
// $data[$i]['']
//Functions::afficheBoiteMsg($n);
for ($i = 1; $i <= $n; $i++) {
    if (($i % 2) == 1) {
       $y = $pdf->GetY() + 2;
        $pdf->SetY($y);

        $pdf->SetFont('Arial', 'B', 12);

$pdf->Cell(95, 65, utf8_decode(""), 1, 2, 'C');
$pdf->MultiCell(0, -65, "", 0, 'L', FALSE);
//photo|etab|annesco|nom|prenoms|datenais|lieunais|sexe|signataire
 if(is_file($data[$i]['libphoto'])){
        $pdf->Image($data[$i]['libphoto'], 11, $y+2, 20, 17);
      } else {    
          if($data[$i]['idsexe']==2){              
        $pdf->Image('../traitement/images/Personnel/homme.jpg', 11, $y+2, 20, 17);
          } else {              
        $pdf->Image('../traitement/images/Personnel/femme.png', 11, $y+2, 20, 17);
          }
      }
        $pdf->Cell(27);
        $pdf->MultiCell(0, 10, strtoupper(utf8_decode('republique du benin')), $border, 'L', $fill);
        $pdf->Cell(27);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->MultiCell(0, 0, (utf8_decode('Ministère des enseignements ')), $border, 'L', $fill);
        $pdf->Cell(20);
        $pdf->MultiCell(0, 10, (utf8_decode('Primaire secondaire et Professionnel')), $border, 'L', $fill);

        $yy = $pdf->GetY();
        $pdf->Image('../img/drapeau.png', 10, ($yy - 2.5), 95, 5);
        $pdf->ln(2);
//libphoto|libetab|libannesco|nom|prenoms|datenaissance|lieunaissance|sexe|signataire
        $pdf->Cell(2);
        $pdf->MultiCell(0, 5, strtoupper(utf8_decode($data[$i]['libetab'])), $border, 'L', $fill);
        $pdf->Cell(2);
        $pdf->MultiCell(0, 5, strtoupper(utf8_decode("Carte scolaire ".$data[$i]['libannesco'])), $border, 'L', $fill);
        $pdf->Cell(2);
        $pdf->MultiCell(0, 5, (utf8_decode("Nom : " . $data[$i]['nom'])), $border, 'L', $fill);
        $pdf->Cell(2);
        $pdf->MultiCell(0, 5, (utf8_decode("Prénoms : " . $data[$i]['prenoms'])), $border, 'L', $fill);
        $pdf->Cell(2);
        $pdf->MultiCell(0, 5, (utf8_decode("Né(e) le : " . $data[$i]['datenaissance'] . '  à ' . $data[$i]['lieunaissance'])), $border, 'L', $fill);
        $pdf->Cell(2);
        $pdf->MultiCell(0, 5, (utf8_decode("Sexe : " . $data[$i]['sexe'])), $border, 'L', $fill);
        $pdf->Cell(27);
        $pdf->MultiCell(0, 5, (utf8_decode("Le Directeur ")), $border, 'L', $fill);
        $pdf->Cell(2);
        $pdf->MultiCell(0, 7, (utf8_decode('Germain Maxime ATOLOU')), $border, 'L', $fill);
 
    } else {
       
 $pdf->SetFont('Arial', 'B', 12);
 
  $pdf->SetY($y);
        $pdf->setX(107);
        $pdf->Cell(95, 65, utf8_decode(""), 1, 2, 'C');
        $pdf->MultiCell(0, -65, "", 0, 'L', FALSE);
        if(is_file($data[$i]['libphoto'])){
        $pdf->Image($data[$i]['libphoto'], 108, ($y +2 ), 20, 17);
        } else {
             if($data[$i]['idsexe']==2){
        $pdf->Image('../traitement/images/Personnel/homme.jpg', 108, ($y +2 ), 20, 17);  
          } else {
        $pdf->Image('../traitement/images/Personnel/femme.png', 108, ($y +2 ), 20, 17);  
          }
        }
        $pdf->Cell(27 + 98);
        $pdf->MultiCell(0, 10, strtoupper(utf8_decode('republique du benin')), $border, 'L', $fill);
        $pdf->Cell(27 + 98);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->MultiCell(0, 0, (utf8_decode('Ministère des enseignements ')), $border, 'L', $fill);
        $pdf->Cell(20 + 98);
        $pdf->MultiCell(0, 10, (utf8_decode('Primaire secondaire et Professionnel')), $border, 'L', $fill);
        $yy = $pdf->GetY();
        $pdf->Image('../img/drapeau.png', (107), ($yy - 2.5), 95, 5);
        $pdf->ln(2);
        $pdf->Cell(2 + 98);
        $pdf->MultiCell(0, 5, strtoupper(utf8_decode($data[$i]['libetab'])), $border, 'L', $fill);
        $pdf->Cell(2 + 98);
        $pdf->MultiCell(0, 5, strtoupper(utf8_decode("Carte scolaire ".$data[$i]['libannesco'])), $border, 'L', $fill);
        $pdf->Cell(2 + 98);
        $pdf->MultiCell(0, 5, (utf8_decode("Nom : " . $data[$i]['nom'])), $border, 'L', $fill);
        $pdf->Cell(2 + 98);
        $pdf->MultiCell(0, 5, (utf8_decode("Prénoms : " . $data[$i]['prenoms'])), $border, 'L', $fill);
        $pdf->Cell(2 + 98);
        $pdf->MultiCell(0, 5, (utf8_decode("Né(e) le : " . $data[$i]['datenaissance'] . '  à ' . $data[$i]['lieunaissance'])), $border, 'L', $fill);
        $pdf->Cell(2 + 98);
        $pdf->MultiCell(0, 5, (utf8_decode("Sexe : " . $data[$i]['sexe'])), $border, 'L', $fill);
        $pdf->Cell(25 + 98);
        $pdf->MultiCell(0, 5, (utf8_decode("Le Directeur ")), $border, 'L', $fill);
        $pdf->Cell(2 + 98);
        $pdf->MultiCell(0, 7, (utf8_decode('Germain Maxime ATOLOU')), $border, 'L', $fill);

    }
    if($i%8==0){      
        $pdf->AddPage();

    }
}
        

$pdf->Output("I");

