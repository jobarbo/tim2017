<?php
$strNiveau = "../../";
require_once($strNiveau . 'inc/scripts/fctcommunes.inc.php');

//Requête permettant d'aller chercher tout le texte de la page Programme
$arrStage = array();
$request = "SELECT * FROM t_texte WHERE section_et_page = 'Stages - International'";

if ($objResult = $objConnMySQLi->query($request)) {
    while ($objLigne = $objResult->fetch_object()) {
        $arrStage[] = array(
            'titre_texte'=>$objLigne->titre_texte,
            'texte'=>$objLigne->texte,
        );
    }
    $objResult->free_result();
    $arrStage = $arrStage[0];
}


$template = $twig->loadTemplate('stages/international/index.html.twig');
echo $template->render(array(
    'niveau' => $strNiveau,
    'page' => "Stage International",
    'arrMenuLiensActifs' => $arrMenuActif,
    'stage' => $arrStage
));
