<?php
if (!isset($_SESSION)) {
    session_start();
}
error_reporting(0);
include_once("../config/connect.php"); //inclusion du fichier de configuration de connection
include('includeclass.php');
require('fpdf/fpdf.php');
include('Class_impression.php');

// Instanciation de la classe dérivée
$pdf = new PDF('P','mm','A4');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
/*
 * Impression du corps du Document
 */

// Formation du titre de la page
$titre = "Bilan Annuel des commissions de l'année ".$_GET['annee'];

// Affichage du titre
$pdf->MultiCell(0, 10, utf8_decode($titre), 0, 'C');

//$pdf->Cell(0, 10, utf8_decode('Bilan Annuel des commissions de l\'année ') . $_GET['annee'], 0, 1, 'L');
$pdf->ln(5);
$pdf->SetFont('Arial', 'B', 12);

$header = array('Mois',  utf8_decode('Commissions'));
$headerBD = array('nommois','montantimp');
$width=array(80,100);
$data=$_SESSION["requete"];
$pdf->FancyTable($header,$headerBD,$data,$width);
$pdf->Output(utf8_decode("Titre"), "I");
?>