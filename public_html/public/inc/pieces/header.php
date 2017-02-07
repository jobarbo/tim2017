<?php
/**
 * Created by PhpStorm.
 * User: annabelleViolette
 * Date: 17-02-07
 */


$arrMenuActif['accueil'] = "";
$arrMenuActif['nousJoindre'] = "";
$arrMenuActif['futurEtudiant'] = "";
$arrMenuActif['programme'] = "";
$arrMenuActif['stages'] = "";
$arrMenuActif['diplomes'] = "";



if (strpos($_SERVER['PHP_SELF'], 'nous_joindre')) {
    echo "NOUS JOINDRE";
    $arrMenuActif['nousJoindre'] = "lien_actif";
}
else if (strpos($_SERVER['PHP_SELF'], 'futur_etudiant')) {
    $arrMenuActif['futurEtudiant'] = "lien_actif";
}
else if (strpos($_SERVER['PHP_SELF'], 'programme')) {
    $arrMenuActif['programme'] = "lien_actif";
}
else if (strpos($_SERVER['PHP_SELF'], 'stages')) {
    $arrMenuActif['stages'] = "lien_actif";
}
else if (strpos($_SERVER['PHP_SELF'], 'diplomes')) {
    $arrMenuActif['diplomes'] = "lien_actif";
}
else {
    $arrMenuActif['accueil'] = "lien_actif";
}

// Pour affichage des variables serveur
// Variables utiles pour les ancres, pour le fil d'Ariane ?...
$variableServerPHP_SELF = $_SERVER['PHP_SELF'];
$variableServerQUERY_STRING = $_SERVER['QUERY_STRING'];