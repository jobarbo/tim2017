<?php


/*************** 1. VARIABLES LOCALES ***********************/
$strNiveau="../../";
$strSection = "Témoignages";
$intIdEtudiant = null;
setlocale(LC_TIME,"fr_CA");

//$intIdEtudiant = rand(482,506);
while( in_array(($intIdEtudiant = rand(482,506)), array(491,492)));



/*************** 2. INSTANCIATION CONFIG ET TWIG ***********************/
require_once($strNiveau . 'inc/scripts/fctcommunes.inc.php');



/*************** 5 TWIG ***********************/

$template = $twig->loadTemplate('futur_etudiant/temoignages/index.html.twig');
echo $template->render(array(
    'niveau' => $strNiveau,
    'page' => "Témoignages | ",

));
