<?php

if (!isset($_SESSION)) {
session_start();
}
error_reporting(0);
include_once("../config/connect.php"); //inclusion du fichier de configuration de connection
require('fpdf/fpdf.php');
include('Class_impressionMEF.php');
include('../class/Functions.php');
include('phpqrcode/qrlib.php'); //On inclut la librairie au projet

// Instanciation de la classe dérivée
$pdf = new PDF($_SESSION["orientationpage"], 'mm', 'A5');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 10);
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
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(0, 20, utf8_decode($v), $border, 'L', $fill);
    }
}

//$corps=$_SESSION["corps"];
//corps du document
// $corps = $laclas . "," . $etab . "," . $an . "," . $appr . "," . $dateinscri . "," . $ref . "," . $totp . "," . $montlettre . ',' . $reste; 
               
$donnee = $_SESSION["corps"]; // // Contenu date location facture client caution avec le titre
$e = explode(",", $donnee);

//$corps = 'Etablissement : '.$e[1]; // entete du tableau
$etab = 'Etablissement : '.$e[1]; // entete du tableau
$an = $e[2];
$clas = $e[0];
$date = $e[4];

$apprenant = $e[3]; 
$numfacture = $e[5]; 
$total = Functions::formatnombre($e[6]); 
$enlettr = $e[7]; 
$totpai = Functions::formatnombre($e[8]); 
$rest = $e[9]; 
$header = array("#", "Désignation", "PU(T.T.C)", "Qte", "Montant (T.T.C"); // entete du tableau
$headerBD = array("num", "designation", "pu", "qte", "montant"); // parametre du tableau (les colonnes) dans $_SESSION["requete"]
$tabAlign = array("L", "L", "R", "R","R");
$width =  array(8, 60, 20, 10,30); // taille de chaque colonne (Leur somme doit donner 190) 
//$header = array("#", "Désignation", "PU(T.T.C)", "Qte", "Groupe Taxe","Montant (T.T.C"); // entete du tableau
//$headerBD = array("num", "designation", "pu", "qte", "group","montant"); // parametre du tableau (les colonnes) dans $_SESSION["requete"]
//$tabAlign = array("L", "L", "R", "R","L","R");
//$width =  array(8, 40, 20, 8,25,30); // taille de chaque colonne (Leur somme doit donner 190) 

//$header = $_SESSION["header"]; // entete du tableau
//$headerBD = $_SESSION["headerBD"]; // parametre du tableau (les colonnes) dans $_SESSION["requete"]
//$tabAlign = $_SESSION["tabAlign"];
//$width = $_SESSION["width"]; // taille de chaque colonne (Leur somme doit donner 190) 
$data = $_SESSION["requete"]; // Contenu du tableau



$don = array(); // Contenu du tableau
$don[0]['num'] = 1;
$don[0]['designation'] = $e[11].' [A]';
$don[0]['pu'] = $total;
$don[0]['qte'] = 1;
//$don[0]['group'] = "A-RESERVE";
$don[0]['montant'] = $total;
//ENtete
// D�calage � droite
//  $pdf->Cell(-90);
//
//$pdf->SetFont('Arial', '', 10);
//  $pdf->MultiCell(0, 5, utf8_decode('ATTOLOU GERMAIN MAXIME                       Adresse : Carrefour Gbèdjromèdé'), 0, 'L', $fill);
//  
//$pdf->SetFont('Arial', '', 10);
//  $pdf->MultiCell(0, 5, utf8_decode('IFU :1201201180008                                      C/1249 Gbèdjromèdé 2 COTONOU'), 0, 'L', $fill);
//$pdf->SetFont('Arial', '', 10);
//  $pdf->MultiCell(0, 5, utf8_decode('RCCM :                                                           Contact : 95710071'), 0, 'L', $fill);
//  $pdf->MultiCell(0, 5, utf8_decode('e-MCF   : EM01016493                                   attolougermain97@gmail.com'), 0, 'L', $fill);
// $pdf->ln(5);
$pdf->SetFont('Arial', '', 10);
  $pdf->MultiCell(0, 5, utf8_decode('RECU N° : '.$numfacture.'                             DATE : '.$date), 0, 'L', $fill);

    $pdf->MultiCell(0, 10, utf8_decode('Classe :  '.$clas).'            '.utf8_decode('Apprenant : '.$apprenant), 0, 'L', $fill);

    $pdf->FancyTable($header, $headerBD, $don, $width, $_SESSION["borduretableau"],$tabAlign);
 $pdf->ln(2);
//  $pdf->MultiCell(0, 10, utf8_decode('Montant payé : '.$total.'         Total payé : '.$totpai), 0, 'L', $fill);
  $pdf->MultiCell(0, 10, utf8_decode('Montant payé : '.$total), 0, 'L', $fill);
  $pdf->MultiCell(0, -10,utf8_decode('Reste à payer : '.$rest), 0, 'R', $fill);
  $pdf->MultiCell(0, 20, utf8_decode('Prochaine échéance    : '.$e[10]), 0, 'L', $fill);
$pdf->ln(2);
$rekete = " SELECT * FROM paramsysteme LIMIT 1 ";
                $norm = Functions::resultatRequete($rekete, 'facturenormalise');
                if ($norm == 1) {
 //=========Début FN
$pdf->SetFont('Arial', '', 8);
  $tcode = explode(';', $data['qrCode']);
$pdf->MultiCell(0, 5,utf8_decode('Code MECeF/DGI :       '.Functions::formatnombre4($tcode[2],' - ')), 0, 'R', $fill);
//$pdf->MultiCell(0, 5,utf8_decode($tcode[2]), 0, 'R', $fill);
$pdf->MultiCell(0, 5,utf8_decode('MECeF NIM :                    '.$tcode[1]), 0, 'R', $fill);
$pdf->MultiCell(0, 5,utf8_decode('MECeF Compteurs :                    '.$data['counters']), 0, 'R', $fill);
$pdf->MultiCell(0, 5,utf8_decode('MECeF Heure :                    '.  Functions::dateHeureDechaineCollee($tcode[4])), 0, 'R', $fill);

//$content= 'http://rkueny.fr';
$filename = 'qrcode.png';
$errorCorrectionLevel = 'L';
$matrixPointSize = 7;

// $content = 'F;TS01000557;TESTZEJ5TAMPTPAC3ZS24ORT;1201201180008;20210809160836';
 $content = $data['qrCode'];//'F;TS01000557;TEST7Z6C37KBPADKKZGBPEFX;1201201180008;20210809162252';

 if($content != ''){
 QRcode::png($content, $filename,
            $errorCorrectionLevel, $matrixPointSize, 2);
$y = $pdf->GetY() - 20 ;
$pdf->Image('qrcode.png', 10, $y, 20, 20);     
 }
}
 //=========Fin FN
 
$pdf->SetFont('Arial', '', 10);
  $pdf->MultiCell(0, 15, utf8_decode('Arrêté le présent reçu à la somme de '.$enlettr.' franc CFA.'), 0, 'C', $fill);

  $pdf->ln(2);
  
//  $_SESSION['idcaissier']
  $pdf->SetFont('Arial', '', 10);
  $pdf->MultiCell(0, 5, utf8_decode("Code vendeur :  ".$_SESSION['idcaissier']."       Nom Vendeur :   " .$_SESSION['caissier']  ), 0, 'R', $fill);
  $pdf->ln(5);
  
//  $pdf->SetFont('Arial', '', 8);
//   $pdf->MultiCell(0, 5, utf8_decode($_SESSION['caissier']), 0, 'R', $fill);
  $pdf->ln(2);
  
//  $pdf->ln(5);
$pdf->SetFont('Arial', 'B', 8);
//$pdf->Image('../images/barnierea.jpg', 15, 15, 50, 20);
$pdf->MultiCell(0, 5, utf8_decode("NB : - Toute somme encaissée n'est plus retournée, ni affectée à un autre compte"), 0, 'L', $fill);
$pdf->MultiCell(0, 5, utf8_decode("         - Tout apprenant qui n'aurait pas respecté l'échéance sera renvoyé des cours et devoirs"), 0, 'L', $fill);


// Affichage de la facture ou pro format

// D�calage � droite
//  $pdf->Cell(130);
//$pdf->MultiCell(0, 5, utf8_decode('DATE : '.$datelocation), 0, 'J', $fill);
//$pdf->SetFont('Arial', '', 12);
//$pdf->Cell(130);
//$pdf->MultiCell(0, 5, utf8_decode('FACTURE N° : '.$numfacture), 0, 'J', $fill);
//$pdf->SetFont('Arial', 'BI', 12);
//$pdf->MultiCell(0, 5, utf8_decode($corps), 0, 'J', $fill);


//// Affichage du tableau
////$pdf->MultiCell(0, 5, utf8_decode(''), $border, 'L', $fill);
//
//$pdf->FancyTable($header, $headerBD, $data, $width, $_SESSION["borduretableau"],$tabAlign);
//
//$pdf->MultiCell(0, 10, utf8_decode('TOTAL HT : '.$ht), 0, 'R', $fill);
//$pdf->MultiCell(0, 10, utf8_decode('Remise : '.$remise), 0, 'R', $fill);
//$pdf->MultiCell(0, 10, utf8_decode('TVA : '.$tva), 0, 'R', $fill);
//
//$pdf->SetFont('Arial', 'BI', 12);
//$pdf->MultiCell(0, 10, utf8_decode('TOTAL TTC : '.$total), 0, 'R', TRUE);
//$pdf->MultiCell(0, 10, utf8_decode('Montant payé : '.$montpaye), 0, 'R', TRUE);
//$pdf->MultiCell(0, 10, utf8_decode('Reste à payer : '.$rest), 0, 'R', TRUE);
//$pdf->MultiCell(0, 10, utf8_decode('Arrêté à la somme de '.$enlettr.' FCFA TTC'), 0, 'L', TRUE);
//$pdf->MultiCell(0, 15, utf8_decode(''), $border, 'L', $fill);
//$pdf->Cell(70);
////$pdf->MultiCell(0, 2, utf8_decode('MENTION : CARBURATION NON PRISE EN CHARGE '), $border, 'L', $fill);

//Bas du document
$tabbas = $_SESSION["basdoc"];
if (sizeof($tab, 1) > 0) {
    foreach ($tabbas as $v) {
        $pdf->ln(1);
        $pdf->SetFont('Arial', 'U', 9);
        $pdf->MultiCell(0, 5, utf8_decode($v), $border, 'R', $fill);
    }
}

$dat = new DateTime();
$gama = $_SESSION["nomfichier"]."_".$dat->format("d-m-Y-H-i-s");
$pdf->Output(utf8_decode($gama), "I");

