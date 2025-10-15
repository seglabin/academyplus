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

//$pdf->ln(2);
//décalage 
// $pdf->Cell(-2);
//$pdf->drawTextBox(utf8_decode(' '), 195, '48', 'C', 'T', 1);
//Haut du document

$k = 0;
$haut = $_SESSION["hautdoc"];
$bas = $_SESSION["basdoc"];
$don = $_SESSION["requete"];

foreach ($haut as $tab) {
    $pdf->ln(5);
//$pdf->Cell(-2);
//$pdf->drawTextBox(utf8_decode('.'), 195, 245, 'C', 'T', TRUE);
//$tab = $_SESSION["hautdoc"];
//    $pdf->Image('../img/logo.png', 175, 35, 28, 30);
    if (sizeof($tab, 1) > 0) {
        $g = 0;
        foreach ($tab as $v) {
//        $pdf->ln(1);
            if($g == 4) $v = '';
            if($g != 4){
            $pdf->SetFont('Arial', '', 10);
            $pdf->MultiCell(0, 7, utf8_decode($v), $border, 'L', $fill);
            }
             $g++;
        }
    }

    $libphto = $tab[4];
$filename = '../' . $libphto;

if (is_file($filename)) {
//        Functions::afficheBoiteMsg("Le fichier $filename existe.");
$pdf->Image($filename, 170, 35, 35, 35);
} else {
//        Functions::afficheBoiteMsg("Le fichier $filename n'existe pas.");
}

//$pdf->Cell(-2);


    $header = $_SESSION["header"]; // entete du tableau
    $headerBD = $_SESSION["headerBD"]; // parametre du tableau (les colonnes) dans $_SESSION["requete"]
    $tabAlign = $_SESSION["tabAlign"];
    $width = $_SESSION["width"]; // taille de chaque colonne (Leur somme doit donner 190) 
    $data = $don[$k]; // Contenu du tableau
// Affichage du tableau
    $pdf->MultiCell(0, 2, utf8_decode(''), $border, 'L', $fill);
    $pdf->SetFont('Arial', '', 10);
    $pdf->FancyTable($header, $headerBD, $data, $width, $_SESSION["borduretableau"], $tabAlign);

    $pdf->MultiCell(0, 5, utf8_decode(''), $border, 'R', $fill);

    $tabbas = $bas[$k];
//if (sizeof($tabbas, 1) > 0) {
    $tb1 = $tabbas[0];
    $tb2 = $tabbas[1];
    $tb3 = $tabbas[2];


    $moyT = $tb1[0]['col3'];
    $rangT = $tb1[0]['col4'];
    $fortT = $tb1[0]['col5'];
    $faiblT = $tb1[0]['col6'];
    $moy = $moyT;
    $syntLit = $tb1[0]['syntLitt'];
    $syntScient = $tb1[0]['syntScient'];

//    print_r($tabbas);

    $yy = $pdf->GetY();
    $y = $pdf->GetY();

    $moyAn = $tb1[0]['Moy_An'];
    $rangAn = $tb1[0]['rangAnnuel'];
    $fortAn = $tb1[0]['fortemoyAnn'];
    $faiblAn = $tb1[0]['faiblemoyAn'];

    $listtitre = array();
    $tabAlign1 = array("L", "C");
    $listcolonneBD = array("col1", "col2");
    $listlargeurtitre = array(40, 20); //total 190


    $tb[0]['col1'] = "MOY TRIMESTRIELLE  ";
    $tb[0]['col2'] = $moyT . '#GRAS#';
//    $tb[0]['col2'] = $moyT;
    $tb[1]['col1'] = "RANG  ";
    $tb[1]['col2'] = $rangT . '#GRAS#';
    $tb[2]['col1'] = "FORTE MOYENNE  ";
    $tb[2]['col2'] = $fortT;
    $tb[3]['col1'] = "FAIBLE MOYENNE  ";
    $tb[3]['col2'] = $faiblT;

    $pdf->FancyTable($listtitre, $listcolonneBD, $tb, $listlargeurtitre, 1, $tabAlign1);
    $pdf->ln(6);
    $listtitreA = array();
    $tabAlignA = array("L", "R"); //, "R");
    $listcolonneBDa = array("col1", "col2"); //, "col3");
    $listlargeurtitrea = array(40, 20); //, 13); //total 190
    $tbs[0]['col1'] = "MOY. 1er TRIM ";
    $tbs[0]['col2'] = $tb3[0]['Moy_S'];
//    $tbs[0]['col3'] = $rangT;
    $tbs[1]['col1'] = "MOY. 2è TRIM ";
    $tbs[1]['col2'] = $tb3[1]['Moy_S'];
//    $tbs[1]['col3'] = "";
    $tbs[2]['col1'] = "MOY. 3è TRIM ";
    $tbs[2]['col2'] = $tb3[2]['Moy_S'];
//    $tbs[2]['col3'] = "";
//    $tbs[0]['col1'] = "MOY. 1er TRIM ";
//    $tbs[0]['col2'] = $moyT;
//    $tbs[0]['col3'] = $rangT;
//    $tbs[1]['col1'] = "MOY. 2è TRIM ";
//    $tbs[1]['col2'] = "";
//    $tbs[1]['col3'] = "";
//    $tbs[2]['col1'] = "MOY. 3è TRIM ";
//    $tbs[2]['col2'] = "";
//    $tbs[2]['col3'] = "";

    $pdf->FancyTable($listtitreA, $listcolonneBDa, $tbs, $listlargeurtitrea, 1, $tabAlign1A);

//    $pdf->$y = Get();

    $pdf->ln(3);

    $listtitre = array();
    $tabAlign1 = array("L", "C");
    $listcolonneBD = array("col1", "col2");
    $listlargeurtitre = array(45, 15); //total 190
    $tb[0]['col1'] = "MOY ANNUELLE  ";
    $tb[0]['col2'] = $moyAn;
    $tb[3]['col1'] = "RANG ANNUEL  ";
    $tb[3]['col2'] = $rangAn;
    $tb[1]['col1'] = "FORTE MOY. ANNUELLE";
    $tb[1]['col2'] = $fortAn;
    $tb[2]['col1'] = "FAIBLE MOY. ANNUELLE";
    $tb[2]['col2'] = $faiblAn;
    $pdf->FancyTable($listtitre, $listcolonneBD, $tb, $listlargeurtitre, 1, $tabAlign1);

//    $pdf->SetFont('Arial', 'B', 12);
//    $pdf->MultiCell(0, 5, utf8_decode("      Signature "), $border, 'L', $fill);
//    $pdf->MultiCell(0, 5, utf8_decode("Professeur Principal"), $border, 'L', $fill);
//    
    //Colonne 2

    $pdf->SetCol(1);

//    $pdf->SetX($left_margin);
    $boolean_variable = TRUE;
    if ($boolean_variable == true)
        $check = "*";
    else
        $check = "";
    $pdf->SetFont('ZapfDingbats', '', 10);
    $checkbox_size = 4;

    $pdf->SetFont('ZapfDingbats', '', 35);
    $pdf->SetY($y);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(60, 10, utf8_decode("Conseil des enseignants"), 1, 2, 'C', TRUE);
    $pdf->ln(2);

    $listtitre3 = array();
    $tabAlign3 = array("L", "C");
    $listcolonneBD3 = array("col1", "col2");
    $listlargeurtitre3 = array(45, 15); //total 190
    $tb3[0]['col1'] = "Félicitation";
    $tb3[0]['col2'] = '';
    $tb3[1]['col1'] = "Encouragement";
    $tb3[1]['col2'] = '';
    $tb3[2]['col1'] = "Tableau d'honneur ";
    $tb3[2]['col2'] = '';
    $tb3[3]['col1'] = "Avertissement";
    $tb3[3]['col2'] = '';
    $tb3[4]['col1'] = "Blame";
    $tb3[4]['col2'] = '';
    $tb3[5]['col1'] = "Renvoi";
    $tb3[5]['col2'] = '';

    $x = $pdf->GetX() + 50;
    $y = $pdf->GetY() + 1;
    $pdf->SetXY($x, ($y - 11));
    $pdf->FancyTable($listtitre3, $listcolonneBD3, $tb3, $listlargeurtitre3, 1, $tabAlign13);
    $tmoy = explode('/', $moy);
    $lamoy = floatval($tmoy[0]);
    $moy = $lamoy;

    $pdf->SetXY($x, $y);
    $coch = ($moy >= 16) ? true : false;
    $pdf->checkbox($pdf, $coch, $checkbox_size);
//     $x = $pdf->GetX() + 48;
    $y += 6;
    $pdf->SetXY($x, $y);
    $coch = ( $moy < 16 && $moy >= 14) ? true : false;
    $pdf->checkbox($pdf, $coch, $checkbox_size);
    $y += 6;
    $pdf->SetXY($x, $y);
    $coch = ( $moy < 14 && $moy >= 12) ? true : false;
    $pdf->checkbox($pdf, $coch, $checkbox_size);
    $y += 6;
    $pdf->SetXY($x, $y);
    $coch = ( $moy < 10 && $moy >= 8) ? true : false;
    $pdf->checkbox($pdf, $coch, $checkbox_size);
    $y += 6;
    $pdf->SetXY($x, $y);
    $coch = ( $moy < 8 && $moy >= 5) ? true : false;
    $pdf->checkbox($pdf, $coch, $checkbox_size);
    $y += 6;
    $pdf->SetXY($x, $y);
    $coch = ( $moy < 5 ) ? true : false;
    $pdf->checkbox($pdf, $coch, $checkbox_size);
    ;
    $pdf->ln(5);

    $pdf->SetFont('Arial', 'B', 12);
//    $fill = true;
////    $pdf->Cell($w, $h, $txt, $border, $ln, $align, $fill, $link);
//    $pdf->Cell(60, 10, utf8_decode($tb2[0]['col2']), 1, 2, 'C');
//    $pdf->SetFont('Arial', 'UB', 12);
//     $pdf->ln(5);   
//    $y = $pdf->GetY();
//    $pdf->MultiCell(60, 5, utf8_decode("Signature "), $border, 'C', $fill);
//    $pdf->MultiCell(60, 5, utf8_decode("Professeur principal"), $border, 'C', $fill);
//    $pdf->SetY($y);
//     $pdf->Cell(60, 30, utf8_decode(""), 1, 2, 'C');
    //    Bas 
    $pdf->SetCol(2);
    $pdf->SetY($yy);
    $y = $pdf->GetY();
    $pdf->SetFont('Arial', 'B', 12);
    $fill = true;
    $pdf->MultiCell(0, 10, utf8_decode('Bilan Scientifique : ' . $syntScient), $border, 'L', $fill);
    $pdf->MultiCell(0, 10, utf8_decode('Bilan Littéraire : ' . $syntLit), $border, 'L', $fill);
    $pdf->SetY($y);
    $pdf->Cell(60, 20, utf8_decode(""), 1, 2, 'C');
    $fill = false;
    $pdf->ln(15);
    $y = $pdf->GetY() - 2;
    $pdf->SetFont('Arial', 'UB', 12);
    $pdf->MultiCell(60, 5, utf8_decode("Signature et cachet "), $border, 'C', $fill);
    $pdf->MultiCell(60, 5, utf8_decode("Directeur"), $border, 'C', $fill);

    $pdf->ln(15);
    $pdf->MultiCell(60, 10, utf8_decode($tb2[0]['col3']), $border, 'C', $fill);
    $pdf->SetY($y);
    $pdf->Cell(60, 40, utf8_decode(""), 1, 2, 'C');
    if ($_SESSION['annuel'] == 1) {
        $pdf->ln(3);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->MultiCell(60, 10, utf8_decode('Décision : ' . $tb1[0]['DecisionAn']), $border, 'C', true); //
    }
    $pdf->SetCol(0);

//    }  else {
////          $pdf->ln(10);
//    }
//     $y = $pdf->GetY();
//      if($_SESSION['annuel'] == 1){
////    Bas 
//    $pdf->SetCol(0); 
//     $pdf->SetFont('Arial', 'B', 12);
//    $pdf->MultiCell(0, 10, utf8_decode('Résultats annuels '), $border, 'L', $fill);
//    $pdf->SetFont('Arial', '', 12);
//    $pdf->MultiCell(0, 5, utf8_decode('Mayenne : '.$tb1[0]['Moy_An']), $border, 'L', $fill);
//    $pdf->MultiCell(0, 5, utf8_decode('Rang : '.$tb1[0]['rangAnnuel']), $border, 'L', $fill);
//    $pdf->MultiCell(0, 5, utf8_decode('Forte moyenne : '.$tb1[0]['fortemoyAnn']), $border, 'L', $fill);
//    $pdf->MultiCell(0, 5, utf8_decode('Faible moyenne : '.$tb1[0]['faiblemoyAn']), $border, 'L', $fill);
//        $moy = $tb1[0]['Moy_An'];
//    }
//    $pdf->ln(2);
//    $pdf->SetFont('Arial', 'B', 12);
//    $pdf->MultiCell(0, 5, utf8_decode("      Signature "), $border, 'L', $fill);
//    $pdf->MultiCell(0, 5, utf8_decode("Professeur Principal"), $border, 'L', $fill);
//    
//    $pdf->SetCol(1); 
//    
////    $pdf->SetX($left_margin);
//    $boolean_variable = TRUE;
//if($boolean_variable == true)
//$check = "*"; else $check = "";
//$pdf->SetFont('ZapfDingbats','', 10);
//$checkbox_size = 4;
//
//    $pdf->SetFont('ZapfDingbats','',35);
//    $pdf->SetY($y);
//     $pdf->SetFont('Arial', 'B', 12);
//    $pdf->MultiCell(0, 5, utf8_decode('Décision du Conseil'), $border, 'L', $fill);
//    $pdf->MultiCell(0, 5, utf8_decode('des enseignants'), $border, 'L', $fill);
//    $pdf->ln(5);
////    $yy = $pdf->GetY();
////    $x  = $pdf->GetX() + 5; $pdf->SetX($x); $pdf->SetY($yy); 
//    $coch = ($moy >= 16)?true:false;
// $pdf->checkbox($pdf,$coch, $checkbox_size);
//    $pdf->MultiCell(0, 5, utf8_decode('Félicitation '), $border, 'L', $fill);
//     $coch = ( $moy < 16 &&  $moy >= 15)?true:false;
//     $pdf->checkbox($pdf,$coch, $checkbox_size);
//    $pdf->MultiCell(0, 5, utf8_decode('Encouragement '), $border, 'L', $fill);
//    $coch = ( $moy < 15 &&  $moy >= 14)?true:false;
//     $pdf->checkbox($pdf,$coch, $checkbox_size);
//    $pdf->MultiCell(0, 5, utf8_decode('Tableau d\'honneur '), $border, 'L', $fill);
//    $coch = ( $moy < 10 &&  $moy >= 8)?true:false;
//     $pdf->checkbox($pdf,$coch, $checkbox_size);
//    $pdf->MultiCell(0, 5, utf8_decode('Avertissement '), $border, 'L', $fill);
//    $coch = ( $moy < 8 &&  $moy >= 6)?true:false;
//     $pdf->checkbox($pdf,$coch, $checkbox_size);
//    $pdf->MultiCell(0, 5, utf8_decode('Blame '), $border, 'L', $fill);
//$coch = ( $moy < 6 )?true:false;
////    $pdf->checkbox($pdf, 4, $checkbox_size, $ori_font_family, $ori_font_size, $ori_font_style);
//    $pdf->checkbox($pdf,$coch, $checkbox_size);
//    $pdf->MultiCell(0, 5, utf8_decode('Renvoi '), $border, 'L', $fill);
//    $pdf->SetFont('Arial', 'B', 12);
//       
//        
//    //    Bas 
//    $pdf->SetCol(2); 
//    $pdf->SetY($y);
//     $pdf->SetFont('Arial', 'B', 12);
//    $pdf->MultiCell(0, 10, utf8_decode('Mention'), $border, 'L', $fill);
//      $pdf->SetFont('Arial', '', 12);
//    $pdf->MultiCell(0, 5, utf8_decode($tb2[0]['col2']), $border, 'L', $fill);
//   $pdf->ln(15);
//     $pdf->SetFont('Arial', 'B', 12);
//    $pdf->MultiCell(0, 5, utf8_decode("Signature et cachet                           Directeur"), $border, 'L', $fill);
//     $pdf->ln(15);
//    $pdf->MultiCell(0, 10, utf8_decode($tb2[0]['col3'].'          '), $border, 'R', $fill);
//    
//    $pdf->SetCol(0); 
//     
//    $pdf->SetFont('Arial', 'B', 12);
//     $pdf->MultiCell(0, 10, utf8_decode('Appréciation du Directeur  :   '.utf8_decode($tb2[0]['col2'])), $border, 'C', $fill);
////    $pdf->MultiCell(0, 10, utf8_decode('Appréciation du Directeur '), $border, 'C', $fill);
//    $pdf->MultiCell(0, 10, utf8_decode($tb2[0]['col2']), $border, 'C', $fill);
//     $pdf->SetFont('Arial', 'BU', 12);
////    $pdf->ln(3);
//    $pdf->MultiCell(0, 10, utf8_decode('Signature'), $border, 'C', $fill);
//     $pdf->SetFont('Arial', 'B', 11);
//    $pdf->MultiCell(0, 10, utf8_decode('Le Professeur Principal                                                     Le Directeur                   '), $border, 'C', $fill);
//    $pdf->ln(8);
//    $pdf->MultiCell(0, 10, utf8_decode($tb2[0]['col3'].'          '), $border, 'R', $fill);
//}
    $yyy = $pdf->GetY();
// $pdf->ln(5);
    $a = (275 - $yyy) + 5;
    $pdf->ln($a);
    $k++;
    if ($k < count($haut))
        $pdf->Cell(0, 1, '', $border, 'R', false);
}


$dat = new DateTime();
$gama = $_SESSION["nomfichier"] . "_" . $dat->format("d-m-Y-H-i-s");
$pdf->Output(utf8_decode($gama), "I");
//}

