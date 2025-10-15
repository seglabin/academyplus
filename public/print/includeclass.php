<?php
if (!isset($_SESSION)) {
    session_start();
}
//Declaration des classes à inclure
//include_once("../class/parametreutilisateurlieu.php");
include_once("../class/ConnectAdmin.php");
include_once("../class/Functions.php");
include_once("../class/utilisateur.php");
include_once("../class/personne.php");
//include_once("../class/structure.php");
include_once("../class/parametre.php");
//include_once("../class/validation.php");
include_once("../class/profil.php");
include_once("../class/userprofil.php");
include_once("../class/menuprofil.php");
include_once("../class/localite.php");
include_once("../class/principarle.php");
include_once("../class/nombreEnLettre.php");

//
//include_once("../class/pays.php");
//include_once("../class/departement.php");
//include_once("../class/commune.php");
//include_once("../class/arrondissement.php");
//include_once("../class/quartier.php");


?>