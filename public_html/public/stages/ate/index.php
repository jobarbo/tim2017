<?php
$strNiveau = "../../";
require_once($strNiveau . 'inc/scripts/fctcommunes.inc.php');

//Requête permettant d'aller chercher tout le texte de la page Programme
$arrStage = array();
$request = "SELECT * FROM t_texte WHERE section_et_page = 'Stages - Alternance travail-études'";

if ($objResult = $objConnMySQLi->query($request)) {
    while ($objLigne = $objResult->fetch_object()) {
        $arrStage[] = array(
            'id'=>$objLigne->id_texte,
            'title'=>$objLigne->titre_texte,
            'text'=>$objLigne->texte,
            'section'=>$objLigne->section_et_page
        );
    }
    $objResult->free_result();
}

$template = $twig->loadTemplate('stages/ate/index.html.twig');
echo $template->render(array(
    'niveau' => $strNiveau,
    'page' => "Alternance Travail-Etudes",
    'arrMenuLiensActifs' => $arrMenuActif,
    'stage' => $arrStage
));