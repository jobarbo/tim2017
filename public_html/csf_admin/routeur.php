<?php

session_start();

/*************** 1. VARIABLES LOCALES ***********************/
$strNiveau = "";
$strNiveauAdmin="../public/";


/*************** 2. INSTANCIATION CONFIG ET TWIG ***********************/
require_once($strNiveau . 'inc/scripts/fctcommunes.inc.php');

if(isset($_SESSION['arrAuthentification'])){

    $arrAuthentification = unserialize($_SESSION['arrAuthentification']);

    switch($arrAuthentification["niveau_acces"]){

        case 1:
            header('Location: fiche_etudiant/index.php?id=' . $arrAuthentification["nom_usager_admin"]);
            exit;
            break;

        case 3:
            header('Location: administration.php');
            exit;
            break;

    }
}