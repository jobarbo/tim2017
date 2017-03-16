<?php
/**
 * Created by PhpStorm.
 * User: annabelleViolette
 * Date: 17-02-07
 */


$arrMenuActif['accueil'] = "";

$arrMenuActif['nousJoindre'] = "";

$arrMenuActif['futurEtudiant'] = "";
$arrMenuActif['integrateur'] = "";
$arrMenuActif['bonChoix'] = "";
$arrMenuActif['profil'] = "";
$arrMenuActif['perspectives'] = "";
$arrMenuActif['temoignages'] = "";

$arrMenuActif['programme'] = "";
$arrMenuActif['apprend'] = "";
$arrMenuActif['equipe'] = "";
$arrMenuActif['grilleCours'] = "";

$arrMenuActif['stages'] = "";
$arrMenuActif['sequences'] = "";
$arrMenuActif['ate'] = "";
$arrMenuActif['international'] = "";

$arrMenuActif['diplomes'] = "";


/*********** SECTION NOUS JOINDRE ***********/
if (strpos($_SERVER['PHP_SELF'], 'nous_joindre')) {
    $arrMenuActif['nousJoindre'] = "lien_actif";
}
/*********** SECTION FUTUR ETUDIANT ***********/
else if (strpos($_SERVER['PHP_SELF'], 'futur_etudiant/bon_choix')) {
    $arrMenuActif['futurEtudiant'] = "lien_actif";
    $arrMenuActif['bonChoix'] = "lien_actif";
}
else if (strpos($_SERVER['PHP_SELF'], 'futur_etudiant/profil')) {
    $arrMenuActif['futurEtudiant'] = "lien_actif";
    $arrMenuActif['profil'] = "lien_actif";
}
else if (strpos($_SERVER['PHP_SELF'], 'futur_etudiant/perspectives')) {
    $arrMenuActif['futurEtudiant'] = "lien_actif";
    $arrMenuActif['perspectives'] = "lien_actif";
}
else if (strpos($_SERVER['PHP_SELF'], 'futur_etudiant/temoignages')) {
    $arrMenuActif['futurEtudiant'] = "lien_actif";
    $arrMenuActif['temoignages'] = "lien_actif";
}
else if (strpos($_SERVER['PHP_SELF'], 'futur_etudiant')) {
    $arrMenuActif['futurEtudiant'] = "lien_actif";
    $arrMenuActif['integrateur'] = "lien_actif";
}

/*********** SECTION PROGRAMME ***********/
else if (strpos($_SERVER['PHP_SELF'], 'programme/equipe')) {
    $arrMenuActif['programme'] = "lien_actif";
    $arrMenuActif['equipe'] = "lien_actif";
}
else if (strpos($_SERVER['PHP_SELF'], 'programme/grille_cours')) {
    $arrMenuActif['programme'] = "lien_actif";
    $arrMenuActif['grilleCours'] = "lien_actif";
}
else if (strpos($_SERVER['PHP_SELF'], 'programme/')) {
    $arrMenuActif['programme'] = "lien_actif";
    $arrMenuActif['apprend'] = "lien_actif";
}

/*********** SECTION STAGES ***********/
else if (strpos($_SERVER['PHP_SELF'], 'stages/ate')) {
    $arrMenuActif['stages'] = "lien_actif";
    $arrMenuActif['ate'] = "lien_actif";
}
else if (strpos($_SERVER['PHP_SELF'], 'stages/international')) {
    $arrMenuActif['stages'] = "lien_actif";
    $arrMenuActif['international'] = "lien_actif";
}
else if (strpos($_SERVER['PHP_SELF'], 'stages/')) {
    $arrMenuActif['stages'] = "lien_actif";
    $arrMenuActif['sequences'] = "lien_actif";
}

/*********** SECTION DIPLOMES ***********/
else if (strpos($_SERVER['PHP_SELF'], 'diplomes/')) {
    $arrMenuActif['diplomes'] = "lien_actif";
}
/*********** ACCUEIL ***********/
else {
    $arrMenuActif['accueil'] = "lien_actif";
}

// Pour affichage des variables serveur
// Variables utiles pour les ancres, pour le fil d'Ariane ?...
$arrMenuActif['PHP_SELF'] = $_SERVER['PHP_SELF'];
if(isset($_SERVER['QUERY_STRING'])){
    $arrMenuActif['QUERY_STRING'] = $_SERVER['QUERY_STRING'];
}
